<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_lab', function (Blueprint $table) {
            $table->timestamp('waktu_mulai_nonaktif')->nullable();
            $table->timestamp('waktu_akhir_nonaktif')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_lab', function (Blueprint $table) {
            $table->dropColumn('waktu_mulai_nonaktif');
            $table->dropColumn('waktu_akhir_nonaktif');
        });
    }
};
