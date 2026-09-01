<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class StudentRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        // Legacy fields (kept for backward compat)
        'name',
        'email',
        'phone',
        'course',           // string — kept for BC
        'roll',
        'parent_name',
        'parent_email',
        'status',
        'reject_reason',

        // New fields
        'application_no',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'blood_group',
        'category',
        'religion',
        'photo_path',
        'alternate_phone',
        'whatsapp_number',
        'permanent_address',
        'current_address',
        'city',
        'state',
        'postal_code',
        'country',
        'course_id',
        'last_institution',
        'board_university',
        'last_qualification',
        'passing_year',
        'percentage_cgpa',
        'roll_registration_no',
        'stream',
        'aadhaar_encrypted',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'submitted_at'  => 'datetime',
        'reviewed_at'   => 'datetime',
        'approved_at'   => 'datetime',
        'rejected_at'   => 'datetime',
    ];

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function guardians()
    {
        return $this->hasMany(StudentRegistrationGuardian::class);
    }

    public function primaryGuardian()
    {
        return $this->hasOne(StudentRegistrationGuardian::class)->where('guardian_type', 'primary');
    }

    public function secondaryGuardian()
    {
        return $this->hasOne(StudentRegistrationGuardian::class)->where('guardian_type', 'secondary');
    }

    public function emergencyContact()
    {
        return $this->hasOne(StudentRegistrationGuardian::class)->where('guardian_type', 'emergency');
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id')
                    ->where('application_type', 'student');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // ──────────────────────────────────────────
    // Aadhaar helpers
    // ──────────────────────────────────────────

    /**
     * Returns masked Aadhaar: XXXX XXXX 1234
     */
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

    /**
     * Decrypt Aadhaar — use only in authorized admin contexts.
     */
    public function decryptAadhaar(): ?string
    {
        if (!$this->aadhaar_encrypted) return null;
        try {
            return Crypt::decryptString($this->aadhaar_encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        if ($this->first_name) {
            return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
        }
        return $this->name ?? '';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'approved'     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'rejected'     => 'bg-red-50 text-red-700 border-red-200',
            'under_review' => 'bg-blue-50 text-blue-700 border-blue-200',
            default        => 'bg-amber-50 text-amber-700 border-amber-200',
        };
    }
}
