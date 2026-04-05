<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subjects',
        'qualification',
        'experience',
        'department',
        'status',
        'reject_reason',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Get subject IDs as array.
     */
    public function getSubjectIdsAttribute(): array
    {
        return array_filter(explode(',', $this->subjects));
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
}
