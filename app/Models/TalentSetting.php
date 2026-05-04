<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentSetting extends Model
{
    protected $fillable = [
        'award',
        'level',
        'points'
    ];
}
