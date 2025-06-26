<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_lab_sesi_jam', function (Blueprint $table) {
            $table->foreignId('id_jadwalLab')->constrained('jadwal_lab', 'id_jadwalLab')->onDelete('cascade');
            $table->foreignId('id_sesi_jam')->constrained('sesi_jam', 'id_sesi_jam')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_lab_sesi_jam');
    }
};
