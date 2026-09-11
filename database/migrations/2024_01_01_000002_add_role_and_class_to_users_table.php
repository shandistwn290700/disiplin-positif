<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role: 'admin' bisa lihat & kelola semua data
            // role: 'guru' hanya bisa lihat & input data siswa di kelasnya (class_id)
            $table->enum('role', ['admin', 'guru'])->default('guru')->after('email');
            $table->foreignId('class_id')->nullable()->after('role')
                  ->constrained('classes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('class_id');
            $table->dropColumn('role');
        });
    }
};
