<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'description',
        'points_required',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
