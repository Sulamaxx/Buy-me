<?php

use extras\plugins\webxpay\WebxPay;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::any('/webxpay-return',[WebxPay::class,'WebxPayConfimation']);
});

