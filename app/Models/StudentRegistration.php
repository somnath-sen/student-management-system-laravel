<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'course',
        'roll',
        'parent_name',
        'parent_email',
        'status',
        'reject_reason',
    ];
}
