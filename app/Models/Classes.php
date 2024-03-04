<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price_id',
        'startTime',
        'length',
        'places',
        'teacher',
        'level',
        'description',
    ];
}
