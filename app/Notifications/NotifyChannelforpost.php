<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
class NotifyChannelforpost extends Notification implements ShouldQueue
{
    public $url="https://app.notify.lk/api/v1/send";

    public function send($Token,$phonenumber)
    {       
        $message = "Buyme.lk - Verify your phone number. The verification code is: $Token.";
        $to = $phonenumber;
        try {
            $request=Http::post($this->url,['user_id'=>config('settings.sms.notify_account_sid'),'api_key'=>config('settings.sms.notify_apikey'),'sender_id'=>config('settings.sms.notify_username'),'to'=>$to,'message'=>$message]);
            $response=$request->json();
        } catch (\Exception $e) {
            echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
        }
        
    }
}