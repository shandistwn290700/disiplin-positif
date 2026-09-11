<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Nama class "SchoolClass", bukan "Class", karena "class" adalah reserved word di PHP.
// Nama tabelnya tetap "classes" (di-set manual di bawah).
class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function teachers()
    {
        return $this->hasMany(User::class, 'class_id');
    }
}
