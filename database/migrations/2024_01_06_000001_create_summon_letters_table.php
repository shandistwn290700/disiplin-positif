<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('summon_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('letter_number')->unique(); // contoh: 001/SDITBN/S.Pem/VII/2026
            $table->integer('points_at_generation'); // snapshot total poin siswa saat surat dibuat
            $table->date('meeting_date');
            $table->string('meeting_time'); // contoh: "09:00"
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('summon_letters');
    }
};
