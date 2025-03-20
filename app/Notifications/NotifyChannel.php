<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
Log::info("log3");
        $message = $notification->toNotify($notifiable);
        Log::info("log1".$message);
        Log::info($notifiable->routeNotificationFor('vonage', $notification));
        if (! $to = $notifiable->routeNotificationFor('vonage', $notification)) {
            Log::info("log1");
            return;
        }
        
//        echo($message."<br><br>".$to."<br><br>".$this->url);
//        exit();
        
        try {
            $request=Http::post($this->url,['user_id'=>config('settings.sms.notify_account_sid'),'api_key'=>config('settings.sms.notify_apikey'),'sender_id'=>config('settings.sms.notify_username'),'to'=>$to,'message'=>$message]);
            $response=$request->json();
            Log::info("log2");
        } catch (\Exception $e) {
            Log::info($e);
            echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
        }
        
    }
}