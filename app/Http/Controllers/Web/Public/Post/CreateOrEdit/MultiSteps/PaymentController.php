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

namespace App\Http\Controllers\Web\Public\Post\CreateOrEdit\MultiSteps;

use App\Helpers\UrlGen;
use App\Http\Controllers\Api\Payment\Promotion\MultiStepsPayment;
use App\Http\Controllers\Api\Payment\HasPaymentReferrers;
use App\Http\Controllers\Web\Public\Payment\HasPaymentRedirection;
use App\Http\Controllers\Web\Public\Post\CreateOrEdit\MultiSteps\Traits\WizardTrait;
use App\Http\Requests\Front\PackageRequest;
use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\Package;
use App\Models\Payment as PaymentModel;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use App\Http\Controllers\Web\Public\FrontController;
use Illuminate\Http\Request;
use Larapen\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\DB;
//use Isurindu\WebxpayLaravel\Facades\Webxpay;

class PaymentController extends FrontController
{
	use HasPaymentReferrers;
	use WizardTrait;
	use MultiStepsPayment, HasPaymentRedirection;
	
	public $request;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware(function ($request, $next) {
			$this->request = $request;
			$this->commonQueries();
			
			return $next($request);
		});
	}
	
	/**
	 * Common Queries
	 *
	 * @return void
	 */
	public function commonQueries(): void
	{
		$this->getPaymentReferrersData();
		$this->setPaymentSettingsForPromotion();
	}
	
	/**
	 * Show the form
	 *
	 * @param $postId
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function getForm($postId, Request $request)
	{
		// Check if the form type is 'Single-Step Form' and make redirection to it (permanently).
		$isSingleStepFormEnabled = (config('settings.single.publication_form_type') == '2');
		if ($isSingleStepFormEnabled) {
			$url = url('edit/' . $postId);
			
			return redirect()->to($url, 301)->withHeaders(config('larapen.core.noCacheHeaders'));
		}
		
		// Get auth user
		$authUser = auth()->user();
		
		// Get Post
		$post = null;
		if (!empty($authUser)) {
			$post = Post::query()
				->inCountry()
				->with([
					'possiblePayment' => fn ($q) => $q->with('package'),
					'paymentEndingLater',
				])
				->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', $authUser->getAuthIdentifier())
				->where('id', $postId)
				->first();
		}
		
		if (empty($post)) {
			abort(404, t('post_not_found'));
		}
		
		view()->share('post', $post);
		$this->shareWizardMenu($request, $post);
		
		// Share the post's current active payment info (If exists)
		$this->getCurrentActivePaymentInfo($post);
		
		// Meta Tags
		MetaTag::set('title', t('update_my_listing'));
		MetaTag::set('description', t('update_my_listing'));
		
		return appView('post.createOrEdit.multiSteps.packages.edit');
	}
	
	/**
	 * Submit the form
	 *
	 * @param $postId
	 * @param \App\Http\Requests\Front\PackageRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
    
    
    public function pgresponselink(Request $request)
	{
        $response_text = base64_decode($request->custom_fields);
        $c_fields[] = explode("|",$response_text);
        $paymentID = '12';//$c_fields[0][2];
        $addID = $c_fields[0][1];
        $packageID = $c_fields[0][0];
        if($request->status_code>0 || is_null($request->status_code))
        {
            $message = "Payment Not Received!".$request->status_code;
            flash($message)->error();
            return redirect()->to('posts/'.$addID.'/payment');
        }
        elseif($request->status_code==0)
        {
            $message = "Payment Received!";
            flash($message)->success();
            
            $post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', $addID)
				->first();
            $post->featured =  1 ;
            $post->save();
            
            $package = Package::query()
				->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', $packageID)
				->first();
            
            $promotiondays = $package->promotion_time;
            $promo_start_date = now()->startOfDay();
            $promo_end_date = now()->endOfDay();
            date_add($promo_end_date,date_interval_create_from_date_string($promotiondays." days"));
            
            $paymentInfo = [
			'payable_id'        => $addID,
			'payable_type'      => 'App\Models\Post',
			'package_id'        => $packageID,
			'payment_method_id' => $paymentID,
			'transaction_id'    => $request->order_refference_number,
			'amount'            => $request->transaction_amount,
			'period_start'      => $promo_start_date,
			'period_end'        => $promo_end_date,
			'active'            => 1,
            ];
            $paymentmodal = new PaymentModel($paymentInfo);
            $paymentmodal->save();
            $dispname = str_replace(" ","-",$post->title)."-".$addID;
            return redirect()->to('/'.$dispname);
        }
    }
    
	public function postForm($postId, PackageRequest $request)
	{
        
		// Add required data in the request for API
		$inputArray = [
			'payable_type' => 'Post',
			'payable_id'   => $postId,
		];
		$request->merge($inputArray);
		
		// Check if the payment process has been triggered
		// NOTE: Payment bypass email or phone verification
		// ===| Make|send payment (if needed) |==============
		
		$post = $this->retrievePayableModel($request, $postId);
        
        
		abort_if(empty($post), 404, t('post_not_found'));
		
		$payResult = $this->isPaymentRequested($request, $post);
        
		if (data_get($payResult, 'success')) {
            
            $authUser = auth()->user();
            DB::table('post_payment_log')->insert(['post_id' => $request->payable_id, 'payment_method' => $request->payment_method_id, 'package_id' => $request->package_id, 'c_or_e' => "E", 'user_id' => $authUser->id, 'date_time' => now()]);
            
			return $this->sendPayment($request, $post);
            
		}
		if (data_get($payResult, 'failure')) {
			flash(data_get($payResult, 'message'))->error();
		}
		// ===| If no payment is made (continue) |===========
		
		$isOfflinePayment = PaymentMethod::query()
			->where('name', 'offlinepayment')
			->where('id', $request->input('payment_method_id'))
			->exists();
		
		// Notification Message
		if (!$isOfflinePayment) {
			flash(t('no_payment_is_made'))->info();
		}
		
		// Get the next URL & Notification
		$nextUrl = UrlGen::post($post);

		return redirect()->to($nextUrl);
	}
}
