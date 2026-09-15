<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['nis', 'name', 'class_id'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function disciplineRecords()
    {
        return $this->hasMany(DisciplineRecord::class);
    }

    public function summonLetters()
    {
        return $this->hasMany(SummonLetter::class);
    }

    // Total poin siswa = jumlah semua poin dari record (positif menambah, negatif mengurangi)
    public function totalPoints(): int
    {
        return $this->disciplineRecords()
            ->join('categories', 'categories.id', '=', 'discipline_records.category_id')
            ->sum('categories.points');
    }
}
