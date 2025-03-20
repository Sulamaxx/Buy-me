<?php 
namespace App\Models;
abstract class NotifyLk{
    public function __construct()
    {
        
    }

    abstract public function Send($message);
}