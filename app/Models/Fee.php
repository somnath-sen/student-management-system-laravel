<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'amount', 'due_date', 'course_id', 'description'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }
}