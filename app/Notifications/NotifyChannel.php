<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
class NotifyChannel extends Notification implements ShouldQueue
{
    public $url="https://app.notify.lk/api/v1/send";

    public function send($notifiable, Notification $notification)
    {
//        echo("location finder 2");
//        exit;
        
//        print_r($notification);
//        
//        echo('<br><br>');
//        
//        print_r($notifiable);
//        
//        
        
        $message = $notification->toNotify($notifiable);
        if (! $to = $notifiable->routeNotificationFor('vonage', $notification)) {
            return;
        }
        
//        echo($message."<br><br>".$to."<br><br>".$this->url);
//        exit();
        
        try {
            $request=Http::post($this->url,['user_id'=>config('settings.sms.notify_account_sid'),'api_key'=>config('settings.sms.notify_apikey'),'sender_id'=>config('settings.sms.notify_username'),'to'=>$to,'message'=>$message]);
            $response=$request->json();
        } catch (\Exception $e) {
            echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
        }
        
    }
}