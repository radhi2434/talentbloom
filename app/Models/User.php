<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'form',
        'class_name',
        'position',
        'role',
        'phone',
        'password',
        'profile_photo',
        'date_joined',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function talents()
    {
        return $this->hasMany(\App\Models\Talent::class, 'student_id');
    }

    public function expertises()
    {
        return $this->belongsToMany(Expertise::class, 'teacher_expertise');
    }

    public function awards()
    {
        return $this->hasMany(\App\Models\TeacherAward::class);
    }
}
