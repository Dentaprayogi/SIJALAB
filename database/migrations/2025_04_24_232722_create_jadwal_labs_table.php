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
        Schema::create('jadwal_lab', function (Blueprint $table) {
            $table->id('id_jadwalLab');
            $table->foreignId('id_hari')->constrained('hari', 'id_hari')->onDelete('cascade');
            $table->foreignId('id_lab')->constrained('lab', 'id_lab')->onDelete('cascade');
            // $table->time('jam_mulai')->nullable();
            // $table->time('jam_selesai')->nullable();
            $table->foreignId('id_mk')->constrained('matakuliah', 'id_mk')->onDelete('cascade');
            $table->foreignId('id_dosen')->constrained('dosen', 'id_dosen')->onDelete('cascade');
            $table->foreignId('id_prodi')->constrained('prodi', 'id_prodi')->onDelete('cascade');
            $table->foreignId('id_kelas')->constrained('kelas', 'id_kelas')->onDelete('cascade');
            $table->foreignId('id_tahunAjaran')->constrained('tahun_ajaran', 'id_tahunAjaran')->onDelete('cascade');
            $table->enum('status_jadwalLab', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_lab');
    }
};
