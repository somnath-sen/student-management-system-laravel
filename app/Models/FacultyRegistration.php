<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class FacultyRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        // Legacy fields (kept for backward compat)
        'name',
        'email',
        'phone',
        'subjects',         // comma-separated IDs — kept for BC
        'qualification',
        'experience',
        'department',
        'status',
        'reject_reason',
        'approved_at',

        // New fields
        'application_no',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'blood_group',
        'marital_status',
        'photo_path',
        'alternate_phone',
        'whatsapp_number',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'designation',
        'years_experience',
        'current_institution',
        'teaching_mode',
        'professional_summary',
        'aadhaar_encrypted',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'approved_by',
        'rejected_at',
        'rejected_by',
    ];

    protected $casts = [
        'approved_at'   => 'datetime',
        'date_of_birth' => 'date',
        'submitted_at'  => 'datetime',
        'reviewed_at'   => 'datetime',
        'rejected_at'   => 'datetime',
    ];

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    public function qualifications()
    {
        return $this->hasMany(FacultyRegistrationQualification::class);
    }

    public function experiences()
    {
        return $this->hasMany(FacultyRegistrationExperience::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id')
                    ->where('application_type', 'faculty');
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
    // Legacy subject helpers
    // ──────────────────────────────────────────

    /**
     * Get subject IDs as array (backward compat).
     */
    public function getSubjectIdsAttribute(): array
    {
        return array_filter(explode(',', $this->subjects ?? ''));
    }

    /**
     * Get subject names from the subjects table.
     */
    public function resolvedSubjects()
    {
        $ids = $this->getSubjectIdsAttribute();
        if (empty($ids)) return collect();
        return Subject::whereIn('id', $ids)->get();
    }

    // ──────────────────────────────────────────
    // Aadhaar helpers
    // ──────────────────────────────────────────

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
