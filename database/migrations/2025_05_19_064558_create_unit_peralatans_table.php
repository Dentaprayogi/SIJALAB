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
        Schema::create('unit_peralatan', function (Blueprint $table) {
            $table->id('id_unit');
            $table->foreignId('id_peralatan')->constrained('peralatan', 'id_peralatan')->onDelete('cascade');
            $table->string('kode_unit')->unique();
            $table->enum('status_unit', ['tersedia', 'dipinjam', 'rusak'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_peralatan');
    }
};
