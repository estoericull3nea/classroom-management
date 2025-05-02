<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'faculty_id',
        'section_id',
        'subject_id',
        'date',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}