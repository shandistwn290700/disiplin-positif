<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SummonLetter extends Model
{
    protected $fillable = [
        'student_id', 'letter_number', 'points_at_generation',
        'meeting_date', 'meeting_time', 'generated_by',
    ];

    protected function casts(): array
    {
        return ['meeting_date' => 'date'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
