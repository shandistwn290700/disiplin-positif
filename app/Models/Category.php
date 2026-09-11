<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'code', 'type', 'severity', 'points'];

    // Label tampilan tingkat keparahan, dipakai di view
    public function severityLabel(): ?string
    {
        return match ($this->severity) {
            'ringan' => 'Ringan',
            'sedang' => 'Sedang',
            'berat' => 'Berat',
            default => null,
        };
    }

    public function disciplineRecords()
    {
        return $this->hasMany(DisciplineRecord::class);
    }
}
