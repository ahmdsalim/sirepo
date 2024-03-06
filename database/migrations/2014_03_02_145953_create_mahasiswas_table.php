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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('npm')->primary();
            $table->string('kode_prodi');
            $table->foreign('kode_prodi')
                ->references('kode_prodi')
                ->on('prodis')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama_mahasiswa');
            $table->string('email')->unique();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
