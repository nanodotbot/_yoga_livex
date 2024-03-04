<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripeid',
        'intent',
        'price_id',
        'type',
        'amount',
        'payment_status',
        'email',
        'name',
        'created',
    ];
}
