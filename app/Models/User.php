<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User → Role relationship
     * (Admin / Teacher / Student)
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * User → Student profile
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * User → Teacher profile
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
}
