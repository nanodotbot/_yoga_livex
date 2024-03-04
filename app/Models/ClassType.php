<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'time_schedule',
        'location',
        'order_position',
        'description',
    ];
}
