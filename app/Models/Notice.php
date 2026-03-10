<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = ['title', 'category', 'content', 'user_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}