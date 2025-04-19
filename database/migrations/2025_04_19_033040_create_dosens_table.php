<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id('id_dosen');
            $table->string('nama_dosen')->unique();
            $table->string('telepon');
            $table->foreignId('id_prodi')->constrained('prodi', 'id_prodi')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};

