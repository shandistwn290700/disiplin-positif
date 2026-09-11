<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Kode poin, contoh: "P-05", "R-02". Unik supaya tidak ada kode ganda.
            $table->string('code')->nullable()->unique()->after('name');

            // Tingkat keparahan, hanya relevan untuk kategori bertipe 'negatif'.
            // Nullable karena kategori 'positif' tidak punya tingkat keparahan.
            $table->enum('severity', ['ringan', 'sedang', 'berat'])->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['code', 'severity']);
        });
    }
};
