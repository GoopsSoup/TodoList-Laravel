<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['list', 'user_id', 'dueDate'];

    protected $casts = [
        'dueDate' => 'date'
    ];

    public function user() {
         return $this->belongsTo(User::class, 'user_id');
    }
}
