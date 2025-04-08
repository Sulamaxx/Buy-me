<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'value',
        'value_type',
        'valid_period',
        'utilized',
        'utilized_date',
        'status',
        'is_active',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'valid_period' => 'datetime',
        'utilized_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
