<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'classes_id',
    ];

    public function users() {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public function classes() {
        return $this->hasMany(Classes::class, 'id', 'classes_id');
    }
}
