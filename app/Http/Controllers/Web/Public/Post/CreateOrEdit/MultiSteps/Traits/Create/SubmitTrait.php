<?php
/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 * Author: BeDigit | https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - https://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Web\Public\Post\CreateOrEdit\MultiSteps\Traits\Create;

use App\Helpers\Files\Upload;
use App\Models\CategoryField;
use App\Models\Coupon;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait SubmitTrait
{
    /**
     * Store all input data in database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function storeInputDataInDatabase(Request $request)
    {
        // Get all saved input data
        $postInput = (array)$request->session()->get('postInput');
        $picturesInput = (array)$request->session()->get('picturesInput');
        $paymentInput = (array)$request->session()->get('paymentInput');

        // Create the global input to send for database saving
        $inputArray = $postInput;
        if (isset($inputArray['category_id'], $inputArray['cf'])) {
            $fields = CategoryField::getFields($inputArray['category_id']);
            if ($fields->count() > 0) {
                foreach ($fields as $field) {
                    if ($field->type == 'file') {
                        if (isset($inputArray['cf'][$field->id]) && !empty($inputArray['cf'][$field->id])) {
                            $inputArray['cf'][$field->id] = Upload::fromPath($inputArray['cf'][$field->id]);
                        }
                    }
                }
            }
        }

        $inputArray['pictures'] = [];
        if (!empty($picturesInput)) {
            foreach ($picturesInput as $key => $filePath) {
                if (!empty($filePath)) {
                    $uploadedFile = Upload::fromPath($filePath);
                    $inputArray['pictures'][] = $uploadedFile;
                }
            }
        }
        $inputArray = array_merge($inputArray, $paymentInput);

        request()->merge($inputArray);

        if (!empty($inputArray['pictures'])) {
            request()->files->set('pictures', $inputArray['pictures']);
        }

        // Call API endpoint
        $endpoint = '/posts';
        $data = makeApiRequest('post', $endpoint, request()->all(), [], true);

        // dd($data);

        // Parsing the API response
        $message = !empty(data_get($data, 'message')) ? data_get($data, 'message') : 'Unknown Error.';

        // HTTP Error Found
        if (!data_get($data, 'isSuccessful')) {
            flash($message)->error();

            if (data_get($data, 'extra.previousUrl')) {
                return redirect()->to(data_get($data, 'extra.previousUrl'))->withInput($request->except('pictures'));
            } else {
                return redirect()->back()->withInput($request->except('pictures'));
            }
        }

        // Get the listing ID
        $postId = data_get($data, 'result.id');

        // Notification Message
        if (data_get($data, 'success')) {
            session()->put('message', $message);

            // Save the listing's ID in session
            if (!empty($postId)) {
                $request->session()->put('postId', $postId);
            }
        } else {
            flash($message)->error();

            return redirect()->back()->withInput($request->except('pictures'));
        }

        // Get Listing Resource
        $post = data_get($data, 'result');

        abort_if(empty($post), 404, t('post_not_found'));

        // Get the next URL
        $nextUrl = url('posts/create/finish');

        if (!empty($paymentInput)) {
            // Check if the payment process has been triggered
            // NOTE: Payment bypass email or phone verification
            // ===| Make|send payment (if needed) |==============

            //Log::info('pckageIds - ' . print_r($request->package_id, true));
            $postObj = $this->retrievePayableModel($request, $postId);
            abort_if(empty($postObj), 404, t('post_not_found'));

            $payResult = $this->isPaymentRequested($request, $postObj);
            if (data_get($payResult, 'success')) {

                $authUser = auth()->user();
                foreach ($request->package_id as $pckageId) {
                    DB::table('post_payment_log')->insert(['post_id' => $postId, 'payment_method' => $request->payment_method_id, 'package_id' => $pckageId, 'c_or_e' => "C", 'user_id' => $authUser->id, 'date_time' => now()]);
                }
                //Log::info('$request--'.print_r($request,true));
                //Log::info('$postObj--'.print_r($postObj,true));
                return $this->sendPayment($request, $postObj);
            }
            if (data_get($payResult, 'failure')) {
                flash(data_get($payResult, 'message'))->error();
            }

            // ===| If no payment is made (continue) |===========
        }

        if (
            data_get($data, 'extra.sendEmailVerification.emailVerificationSent')
            || data_get($data, 'extra.sendPhoneVerification.phoneVerificationSent')
        ) {
            session()->put('itemNextUrl', $nextUrl);

            if (data_get($data, 'extra.sendEmailVerification.emailVerificationSent')) {
                session()->put('emailVerificationSent', true);

                // Show the Re-send link
                $this->showReSendVerificationEmailLink($post, 'posts');
            }

            if (data_get($data, 'extra.sendPhoneVerification.phoneVerificationSent')) {
                session()->put('phoneVerificationSent', true);

                // Show the Re-send link
                $this->showReSendVerificationSmsLink($post, 'posts');

                // Phone Number verification
                // Get the token|code verification form page URL
                // The user is supposed to have received this token|code by SMS
                $nextUrl = url('posts/verify/phone/');
            }
        }

        // Mail Notification Message
        if (data_get($data, 'extra.mail.message')) {
            $mailMessage = data_get($data, 'extra.mail.message');
            if (data_get($data, 'extra.mail.success')) {
                flash($mailMessage)->success();
            } else {
                flash($mailMessage)->error();
            }
        }

        // Clear Temporary Inputs & Files
        $this->clearTemporaryInput();

        $totalAmount = 0;
        foreach ($request->input('package_id') as $pid) {
            $package = Package::find($pid);
            $totalAmount = $totalAmount + $package->price;
        }
        if ($totalAmount > 0) {
            $couponCode = $request->input('coupon_code');

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)
                    ->first();


                if ($coupon) {
                    $coupon->utilized = 'Yes';
                    $coupon->user_id = Auth::user()->id;
                    $coupon->utilized_date = now();
                    $coupon->is_active = 0;

                    // Save the updated coupon
                    $coupon->save();
                }
            }
        }


        return redirect()->to($nextUrl);
    }

    private function storeInputDataInDatabasePayment(Request $request)
    {
        $postInput = (array)$request->session()->get('postInput');
        $paymentInputs = (array)$request->session()->get('paymentInput');

        $inputArray = $postInput;

        // Process each payment input individually
        if (!empty($paymentInputs)) {
            foreach ($paymentInputs as $index => $paymentInput) {
                // Merge the current payment input into the request
                $request->merge($paymentInput);

                // Process the single package's input array
                $singleInputArray = array_merge($inputArray, $paymentInput);

                // Set pictures if they exist
                if (!empty($singleInputArray['pictures'])) {
                    $request->files->set('pictures', $singleInputArray['pictures']);
                }

                // Call API endpoint for this package
                $endpoint = '/posts';
                $data = makeApiRequest('post', $endpoint, $singleInputArray, [], true);

                // Parsing the API response
                $message = !empty(data_get($data, 'message')) ? data_get($data, 'message') : 'Unknown Error.';

                // HTTP Error Found
                if (!data_get($data, 'isSuccessful')) {
                    flash($message)->error();

                    if (data_get($data, 'extra.previousUrl')) {
                        return redirect()->to(data_get($data, 'extra.previousUrl'))->withInput($request->except('pictures'));
                    } else {
                        return redirect()->back()->withInput($request->except('pictures'));
                    }
                }

                // Get the listing ID for this package
                $postId = data_get($data, 'result.id');

                // Notification Message
                if (data_get($data, 'success')) {
                    session()->put('message', $message);

                    // Save the listing's ID in session (for the first package or update as needed)
                    if (!empty($postId) && $index === 0) {
                        $request->session()->put('postId', $postId);
                    }
                } else {
                    flash($message)->error();
                    return redirect()->back()->withInput($request->except('pictures'));
                }

                // Get Listing Resource
                $post = data_get($data, 'result');
                abort_if(empty($post), 404, t('post_not_found'));

                // Payment Processing for this package
                if (!empty($paymentInput)) {
                    $postObj = $this->retrievePayableModel($request, $postId);
                    abort_if(empty($postObj), 404, t('post_not_found'));

                    $payResult = $this->isPaymentRequested($request, $postObj);
                    if (data_get($payResult, 'success')) {
                        $authUser = auth()->user();

                        // Insert payment log for this package
                        DB::table('post_payment_log')->insert([
                            'post_id' => $postId,
                            'payment_method' => $paymentInput['payment_method_id'],
                            'package_id' => $paymentInput['package_id'],
                            'c_or_e' => "C",
                            'user_id' => $authUser->id,
                            'date_time' => now(),
                        ]);

                        return $this->sendPayment($request, $postObj);
                    }
                    if (data_get($payResult, 'failure')) {
                        flash(data_get($payResult, 'message'))->error();
                    }
                }
            }
        } else {
            // No payment inputs, process as a single request
            $inputArray = array_merge($inputArray, $paymentInputs);
            if (!empty($inputArray['pictures'])) {
                $request->files->set('pictures', $inputArray['pictures']);
            }

            $endpoint = '/posts';
            $data = makeApiRequest('post', $endpoint, $inputArray, [], true);

            // Parsing the API response
            $message = !empty(data_get($data, 'message')) ? data_get($data, 'message') : 'Unknown Error.';

            if (!data_get($data, 'isSuccessful')) {
                flash($message)->error();

                if (data_get($data, 'extra.previousUrl')) {
                    return redirect()->to(data_get($data, 'extra.previousUrl'))->withInput($request->except('pictures'));
                } else {
                    return redirect()->back()->withInput($request->except('pictures'));
                }
            }

            $postId = data_get($data, 'result.id');

            if (data_get($data, 'success')) {
                session()->put('message', $message);
                if (!empty($postId)) {
                    $request->session()->put('postId', $postId);
                }
            } else {
                flash($message)->error();
                return redirect()->back()->withInput($request->except('pictures'));
            }

            $post = data_get($data, 'result');
            abort_if(empty($post), 404, t('post_not_found'));
        }

        // Handle verification and next steps
        $nextUrl = url('posts/create/finish');
        if (
            data_get($data, 'extra.sendEmailVerification.emailVerificationSent')
            || data_get($data, 'extra.sendPhoneVerification.phoneVerificationSent')
        ) {
            session()->put('itemNextUrl', $nextUrl);

            if (data_get($data, 'extra.sendEmailVerification.emailVerificationSent')) {
                session()->put('emailVerificationSent', true);
                $this->showReSendVerificationEmailLink($post, 'posts');
            }

            if (data_get($data, 'extra.sendPhoneVerification.phoneVerificationSent')) {
                session()->put('phoneVerificationSent', true);
                $this->showReSendVerificationSmsLink($post, 'posts');
                $nextUrl = url('posts/verify/phone/');
            }
        }

        // Mail Notification
        if (data_get($data, 'extra.mail.message')) {
            $mailMessage = data_get($data, 'extra.mail.message');
            if (data_get($data, 'extra.mail.success')) {
                flash($mailMessage)->success();
            } else {
                flash($mailMessage)->error();
            }
        }

        // Clear Temporary Inputs & Files
        $this->clearTemporaryInput();

        return redirect()->to($nextUrl);
    }
}
