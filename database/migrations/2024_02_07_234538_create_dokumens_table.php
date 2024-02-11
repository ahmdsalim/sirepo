<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('penulis');
            $table->string('tahun');
            $table->string('username');
            $table->foreign('username')
                ->references('username')
                ->on('users');
            $table->foreignId('jenis_id')
                ->constrained('jenis')
                ->onDelete('cascade');
            $table->string('file');
            $table->text('abstrak');
            $table->string('keyword');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
