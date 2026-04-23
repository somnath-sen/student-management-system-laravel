<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'risk_score',
        'risk_level',
        'attendance_score',
        'marks_score',
        'engagement_score',
        'insights',
        'suggestions',
        'last_evaluated_at',
    ];

    protected $casts = [
        'insights'         => 'array',
        'suggestions'      => 'array',
        'last_evaluated_at'=> 'datetime',
        'risk_score'       => 'float',
        'attendance_score' => 'float',
        'marks_score'      => 'float',
        'engagement_score' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
