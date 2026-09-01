<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class StudentRegistrationGuardian extends Model
{
    protected $fillable = [
        'student_registration_id',
        'guardian_type',
        'full_name',
        'relationship',
        'phone',
        'email',
        'occupation',
        'annual_income',
        'aadhaar_encrypted',
    ];

    public function registration()
    {
        return $this->belongsTo(StudentRegistration::class, 'student_registration_id');
    }

    public function getMaskedAadhaarAttribute(): string
    {
        if (!$this->aadhaar_encrypted) return 'Not provided';
        try {
            $plain = Crypt::decryptString($this->aadhaar_encrypted);
            return 'XXXX XXXX ' . substr($plain, -4);
        } catch (\Exception $e) {
            return 'XXXX XXXX XXXX';
        }
    }
}
