<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ApplicationDocument extends Model
{
    protected $fillable = [
        'application_type',
        'application_id',
        'document_type',
        'document_label',
        'original_name',
        'stored_path',
        'disk',
        'mime_type',
        'file_size',
        'uploaded_at',
        'uploaded_by',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'file_size'   => 'integer',
    ];

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeForStudent($query, int $id)
    {
        return $query->where('application_type', 'student')->where('application_id', $id);
    }

    public function scopeForFaculty($query, int $id)
    {
        return $query->where('application_type', 'faculty')->where('application_id', $id);
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 2) . ' MB';
    }

    public function isImage(): bool
    {
        return in_array($this->mime_type, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    public function storageExists(): bool
    {
        return Storage::disk($this->disk ?? 'local')->exists($this->stored_path);
    }
}
