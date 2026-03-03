<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['list', 'user_id', 'dueDate', 'completed', 'favourite'];

    protected $casts = [
        'dueDate' => 'date',
        'completed' => 'boolean',
        'favourite' => 'boolean'
    ];

    public function user() {
         return $this->belongsTo(User::class, 'user_id');
    }
}
