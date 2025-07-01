<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_manual', function (Blueprint $table) {
            $table->foreignId('id_peminjaman')->constrained('peminjaman', 'id_peminjaman')->onDelete('cascade');
            $table->foreignId('id_sesi_mulai')->constrained('sesi_jam', 'id_sesi_jam')->onDelete('cascade');
            $table->foreignId('id_sesi_selesai')->constrained('sesi_jam', 'id_sesi_jam')->onDelete('cascade');
            // $table->time('jam_mulai')->nullable();
            // $table->time('jam_selesai')->nullable();
            $table->foreignId('id_lab')->constrained('lab', 'id_lab')->onDelete('cascade');
            $table->string('kegiatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_manual');
    }
};
