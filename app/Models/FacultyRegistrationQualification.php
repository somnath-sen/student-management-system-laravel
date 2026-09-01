<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyRegistrationQualification extends Model
{
    protected $fillable = [
        'faculty_registration_id',
        'degree',
        'institution',
        'university',
        'specialization',
        'passing_year',
        'percentage_cgpa',
    ];

    public function registration()
    {
        return $this->belongsTo(FacultyRegistration::class, 'faculty_registration_id');
    }
}
