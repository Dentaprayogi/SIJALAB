<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            // Foreign keys
            $table->foreignId('id')->constrained('users', 'id')->onDelete('cascade'); 
            $table->foreignId('id_prodi')->constrained('prodi', 'id_prodi')->onDelete('cascade'); 
            $table->foreignId('id_kelas')->constrained('kelas', 'id_kelas')->onDelete('cascade'); 
            $table->string('nim')->unique();
            $table->string('telepon');
            $table->string('foto_ktm', 10240)->nullable();
            $table->timestamps();

            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
