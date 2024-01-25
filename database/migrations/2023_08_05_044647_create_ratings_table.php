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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('buku_id')
                  ->constrained('bukus')
                  ->onDelete('cascade');
            $table->tinyInteger('score');
            $table->timestamps();

            $table->foreign('email')->references('email')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function(Blueprint $table) {
            $table->dropForeign('email');
            $table->dropForeign('buku_id');
        });

        Schema::dropIfExists('ratings');
    }
};
