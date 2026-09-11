<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplineRecord extends Model
{
    protected $fillable = [
        'student_id', 'category_id', 'recorded_by', 'description', 'date',
    ];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
