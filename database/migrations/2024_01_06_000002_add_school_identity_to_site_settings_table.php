<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('school_government_line')->nullable()->after('welcome_message'); // "Pemerintah Kabupaten Bandung"
            $table->string('school_name')->nullable()->after('school_government_line'); // "SDIT Bahtera Nuh"
            $table->string('school_address')->nullable()->after('school_name');
            $table->string('school_email')->nullable()->after('school_address');
            $table->string('school_city')->nullable()->after('school_email'); // "Katapang" - dipakai di header tanggal surat
            $table->string('waka_kesiswaan_name')->nullable()->after('school_city');
            $table->string('principal_name')->nullable()->after('waka_kesiswaan_name');
            $table->integer('summon_letter_threshold')->default(-100)->after('principal_name'); // ambang poin pemanggilan
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'school_government_line', 'school_name', 'school_address', 'school_email',
                'school_city', 'waka_kesiswaan_name', 'principal_name', 'summon_letter_threshold',
            ]);
        });
    }
};
