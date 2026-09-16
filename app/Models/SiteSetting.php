<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'hero_image', 'favicon', 'welcome_message',
        'school_government_line', 'school_name', 'school_address', 'school_email', 'school_city',
        'waka_kesiswaan_name', 'principal_name', 'summon_letter_threshold',
        'government_logo', 'school_logo',
    ];

    // Selalu ambil (atau buat) satu baris pengaturan saja — aplikasi ini cuma butuh 1 set pengaturan global
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
