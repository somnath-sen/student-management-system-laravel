<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    // Merged safely: kept your original fields and added the new one
    protected $fillable = [
        'name',
        'description',
        'admit_cards_published', 
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    // Added this so the Admin Dashboard can count the students in each course!
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}