<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'roll_number',
        'phone',
        'profile_photo',
        'parent_name',
        'emergency_phone', 
        'blood_group', 
        'home_address',
        'last_lat',
        'last_lng',
        'location_updated_at',
        'is_panicking',
        'panic_lat',
        'panic_lng',
        'panic_triggered_at',
        'report_card_remark',
    ];

    protected $casts = [
        'location_updated_at' => 'datetime',
        'panic_triggered_at'  => 'datetime',
        'is_panicking'        => 'boolean',
    ];

    /**
     * Get the authoritative profile photo URL (or fallback to registration photo).
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        if ($this->profile_photo) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->profile_photo)) {
                return asset('storage/' . $this->profile_photo);
            }
            if (\Illuminate\Support\Facades\Storage::disk('local')->exists($this->profile_photo)) {
                return route('student.profile.photo');
            }
        }

        // Graceful fallback to registration photo if student profile photo not yet set
        $reg = $this->user?->studentRegistration;
        if ($reg && $reg->photo_path) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($reg->photo_path)) {
                return asset('storage/' . $reg->photo_path);
            }
            if (\Illuminate\Support\Facades\Storage::disk('local')->exists($reg->photo_path)) {
                return route('student.profile.photo');
            }
        }

        return null;
    }

    /**
     * Get base64 Data URI for the profile photo.
     * Guarantees 100% reliable canvas export/download (no CORS, no tainted canvas).
     */
    public function getProfilePhotoBase64Attribute(): ?string
    {
        $path = $this->profile_photo;
        $disk = 'public';

        if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            $disk = 'public';
        } elseif ($path && \Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
            $disk = 'local';
        } else {
            $reg = $this->user?->studentRegistration;
            if ($reg && $reg->photo_path) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($reg->photo_path)) {
                    $path = $reg->photo_path;
                    $disk = 'public';
                } elseif (\Illuminate\Support\Facades\Storage::disk('local')->exists($reg->photo_path)) {
                    $path = $reg->photo_path;
                    $disk = 'local';
                }
            }
        }

        if (!$path || !\Illuminate\Support\Facades\Storage::disk($disk)->exists($path)) {
            return null;
        }

        try {
            $content = \Illuminate\Support\Facades\Storage::disk($disk)->get($path);
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mime = match ($ext) {
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                default => 'image/jpeg',
            };
            return 'data:' . $mime . ';base64,' . base64_encode($content);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Get two-letter initials for avatar fallback (e.g. "RS").
     */
    public function getInitialsAttribute(): string
    {
        $name = trim($this->user?->name ?? 'Student');
        $words = array_values(array_filter(explode(' ', $name)));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        }
        return strtoupper(substr($name, 0, min(2, strlen($name))));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'parent_id');
    }

    public function messageReads()
    {
        return $this->hasMany(MessageRead::class);
    }

    /**
     * Count unread broadcast messages for this student
     * across all subjects in their course.
     */
    public function unreadBroadcastCount(): int
    {
        $subjectIds = \App\Models\Subject::where('course_id', $this->course_id)->pluck('id');

        $messageIds = \App\Models\BroadcastMessage::whereIn('subject_id', $subjectIds)->pluck('id');

        $readIds = \App\Models\MessageRead::where('student_id', $this->id)
            ->where('seen', true)
            ->pluck('message_id');

        return $messageIds->diff($readIds)->count();
    }
}