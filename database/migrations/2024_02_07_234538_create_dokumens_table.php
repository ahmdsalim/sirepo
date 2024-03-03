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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('penulis');
            $table->text('pembimbing');
            $table->text('penguji');
            $table->string('tahun');
            $table->string('username');
            $table->foreign('username')
                ->references('username')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('jenis_id')
                ->constrained('jenis')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('file')->nullable();
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
