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
        Schema::create('bacas', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('buku_id')
                  ->constrained('bukus')
                  ->onDelete('cascade');
            $table->tinyInteger('prev_progress');
            $table->tinyInteger('progress');
            $table->dateTime('started_at');
            $table->dateTime('end_at');

            $table->foreign('email')->references('email')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bacas', function(Blueprint $table) {
            $table->dropForeign('email');
            $table->dropForeign('buku_id');
        });

        Schema::dropIfExists('bacas');
    }
};
