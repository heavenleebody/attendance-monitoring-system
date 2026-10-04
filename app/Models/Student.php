<?php

// Randell added this file | October 4, 2026 | 11:01 AM | student record, saved by the admin registration form

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'course',
        'year_level',
        'section',
        'photo_url',
    ];
}
