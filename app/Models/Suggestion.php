<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'user_id',
        'analysis_json',
        'suggestions_json',
        'overall_level',
        'generated_at',
    ];

    protected $casts = [
        'analysis_json'    => 'array',
        'suggestions_json' => 'array',
        'generated_at'     => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
