<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $classNames = [
            '1A - Abu Bakar Ash-Shidiq',
            '1B - Umar bin Khattab',
            '2A - Utsman bin Affan',
            '2B - Ali bin Abi Thalib',
            '3A - Thalhah bin Ubaidillah',
            '3B - Zubair bin Awwam',
            '4A - Saad bin Abi Waqqas',
            '4B - Said bin Zaid',
            '5A - Abdurrahman bin Auf',
            '5B - Abu Ubaidah bin Jarah',
            "6A - Abdullah bin Mas'ud",
            '6B - Abdullah bin Abbas',
        ];

        $classes = collect($classNames)->map(fn ($name) => SchoolClass::create(['name' => $name]));

        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Bu Sari',
            'email' => 'guru@sekolah.test',
            'password' => 'password',
            'role' => 'guru',
            'class_id' => $classes->first()->id, // wali kelas 1A
        ]);

        $categories = [
            // Pelanggaran ringan
            ['code' => 'P-01', 'name' => 'Terlambat masuk kelas', 'type' => 'negatif', 'severity' => 'ringan', 'points' => -2],
            ['code' => 'P-02', 'name' => 'Tidak memakai atribut lengkap', 'type' => 'negatif', 'severity' => 'ringan', 'points' => -2],
            // Pelanggaran sedang
            ['code' => 'P-03', 'name' => 'Tidak mengerjakan PR', 'type' => 'negatif', 'severity' => 'sedang', 'points' => -5],
            ['code' => 'P-04', 'name' => 'Mengganggu teman saat belajar', 'type' => 'negatif', 'severity' => 'sedang', 'points' => -5],
            // Pelanggaran berat
            ['code' => 'P-05', 'name' => 'Berkelahi dengan teman', 'type' => 'negatif', 'severity' => 'berat', 'points' => -15],
            ['code' => 'P-06', 'name' => 'Bolos sekolah', 'type' => 'negatif', 'severity' => 'berat', 'points' => -15],
            // Pencapaian positif
            ['code' => 'A-01', 'name' => 'Membantu teman', 'type' => 'positif', 'severity' => null, 'points' => 5],
            ['code' => 'A-02', 'name' => 'Aktif bertanya di kelas', 'type' => 'positif', 'severity' => null, 'points' => 3],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
