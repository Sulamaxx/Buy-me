<?php

namespace extras\plugins\webxpay;

use App\Helpers\Number;
use App\Models\Post;
use App\Models\User;
use extras\plugins\webxpay\app\Traits\InstallTrait;
use Illuminate\Http\Request;
use App\Helpers\Payment;
use App\Models\Package;
use Illuminate\Support\Facades\Log;

class Webxpay extends Payment
{
	use InstallTrait;
	
	/**
	 * Send Payment
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Post|\App\Models\User $payable
	 * @param array $resData
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public static function sendPayment(Request $request, Post|User $payable, array $resData = [])
	{
		// Set the right URLs
		parent::setRightUrls($resData);
		
		// Get the Package
		$package = Package::find($request->input('package_id'));
		
		// Don't make a payment if 'price' = 0 or null
		if (empty($package) || $package->price <= 0) {
			return redirect()->to(parent::$uri['previousUrl'] . '?error=package')->withInput();
		}
		// Don't make payment if selected Package is not compatible with payable (Post|User)
		if (!parent::isPayableCompatibleWithPackage($payable, $package)) {
			return redirect()->to(parent::$uri['previousUrl'] . '?error=packageType')->withInput();
		}
		$publickey=config('payment.webxpay.public_key');
		$secret_key=config('payment.webxpay.secret_key');
		$sandbox=config('payment.webxpay.sandbox');
		$url="https://webxpay.com/index.php?route=checkout/billing";
		if($sandbox === true){
			$url="https://stagingxpay.info/index.php?route=checkout/billing"; 
		}
		// Get the amount
		$amount = Number::toFloat($package->price);
		$custom_fields = base64_encode($package->id.'|'.$payable->id);
		$referenceId = md5($payable->id . $package->id . $package->type . uniqid('', true));
		$plaintext = $referenceId.'|'.floor($amount);
		openssl_public_encrypt($plaintext, $encrypt, $publickey);
		$payment = base64_encode($encrypt);
		$user=auth()->user();
		return view('payment::payment',['user'=>$user,'custom_fields'=>$custom_fields,'secret_key'=>$secret_key,'payment'=>$payment,'url'=>$url]);

	}

	public static function sendPaymentPost(Request $request, Post $payable, array $resData = [])
	{
		// Set the right URLs
		parent::setRightUrls($resData);
		
		// Get the Package
		$package = null;
        $totalAmount=0;
		foreach($request->input('package_id') as $pid){
			$package=Package::find($pid);
			$totalAmount=$totalAmount+$package->price;
		}

		// Don't make a payment if 'price' = 0 or null
		if (empty($package) || $totalAmount <= 0) {
			Log::info('Log111');
			return redirect()->to(parent::$uri['previousUrl'] . '?error=package')->withInput();
		}
		// Don't make payment if selected Package is not compatible with payable (Post|User)
		if (!parent::isPayableCompatibleWithPackage($payable, $package)) {
			Log::info('Log222');
			return redirect()->to(parent::$uri['previousUrl'] . '?error=packageType')->withInput();
		}
		$publickey=config('payment.webxpay.public_key');
		$secret_key=config('payment.webxpay.secret_key');
		$sandbox=config('payment.webxpay.sandbox');
		$url="https://webxpay.com/index.php?route=checkout/billing";
		if($sandbox === true){
			$url="https://stagingxpay.info/index.php?route=checkout/billing"; 
		}
		// Get the amount
		$amount = Number::toFloat($totalAmount);
		$custom_fields = base64_encode($package->id.'|'.$payable->id);
		$referenceId = md5($payable->id . $package->id . $package->type . uniqid('', true));
		$plaintext = $referenceId.'|'.floor($amount);
		openssl_public_encrypt($plaintext, $encrypt, $publickey);
		$payment = base64_encode($encrypt);
		$user=auth()->user();
		return view('payment::payment',['user'=>$user,'custom_fields'=>$custom_fields,'secret_key'=>$secret_key,'payment'=>$payment,'url'=>$url]);

	}
	
	public static function WebxPayConfimation(Request $request){
		//decode & get POST parameters
		$payment = base64_decode($request->payment);
		$signature = base64_decode($request->signature);
		$custom_fields = base64_decode($request->custom_fields);
		//load public key for signature matching
		$publickey = config('app.webxpay.public_key');
		openssl_public_decrypt($signature, $value, $publickey);
		$signature_status = false ;
		if($value == $payment){
			$signature_status = true ;
		}
		//get payment response in segments
		//payment format: order_id|order_refference_number|date_time_transaction|payment_gateway_used|status_code|comment;
		$responseVariables = explode('|', $payment);      
		$customeVaribles = explode('|', $custom_fields);  
		if(isset($customeVaribles[0])){
			$package = Package::find($customeVaribles[0]);
			$isPromoting = ($package->type == 'promotion');
			$isSubscripting = ($package->type== 'subscription');
		}
		$payable = null;
		if ($isPromoting) {
			$payable = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', $customeVaribles[1])
				->first();
		}
		if ($isSubscripting) {
			$payable = User::withoutGlobalScopes([VerifiedScope::class])
				->where('id', $customeVaribles[1])
				->first();
		}
		if($signature_status == true && isset($package->id) && $payable){
			return self::paymentConfirmationActions($payable, ['transaction_id'=>$responseVariables[1]]);
		}else{
			return parent::paymentFailureActions($payable);
		}
	}

	/**
	 * NOTE: Not managed by a route.
	 * Check the method: \App\Http\Controllers\Api\Payment\MakePayment::paymentConfirmation()
	 *
	 * @param \App\Models\Post|\App\Models\User $payable
	 * @param array $params
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public static function paymentConfirmation(Post|User $payable, array $params)
	{
		// Replace patterns in URLs
		parent::$uri = parent::replacePatternsInUrls($payable, parent::$uri);
		// Get Charge ID
		$approvedOrderId = $params['transaction_id'] ?? null;
		// Try to make the Payment
		try {
			// Creating an environment
			return parent::paymentConfirmationActions($payable, $params);
		} catch (\Throwable $e) {
			
			// Apply actions when API failed
			return parent::paymentApiErrorActions($payable, $e);
			
		}
	}
}
