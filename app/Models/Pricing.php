<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'priceid',
        'price',
        'amount',
        'location',
        'order_position',
        'description',
    ];
}
