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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('jk');
            $table->string('telepon');
            $table->string('npsn');
            $table->timestamps();

            $table->foreign('npsn')->references('npsn')->on('sekolahs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function(Blueprint $table) {
            $table->dropForeign('npsn');
        });
        Schema::dropIfExists('gurus');
    }
};
