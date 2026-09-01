<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyRegistrationExperience extends Model
{
    protected $fillable = [
        'faculty_registration_id',
        'institution',
        'designation',
        'department',
        'start_date',
        'end_date',
        'is_current',
        'responsibilities',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
    ];

    public function registration()
    {
        return $this->belongsTo(FacultyRegistration::class, 'faculty_registration_id');
    }
}
