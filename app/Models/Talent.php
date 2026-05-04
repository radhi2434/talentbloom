<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    protected $table = 'talent';

    protected $fillable = [
        'student_id',
        'title',
        'category',
        'level',
        'award',     
        'points',     
        'updated_by',  
        'achieved_at',
        'description',
        'proof_path',
    ];

    protected $casts = [
        'achieved_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}