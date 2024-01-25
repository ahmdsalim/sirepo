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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique();
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
        Schema::table('siswas', function(Blueprint $table) {
            $table->dropForeign('npsn');
        });
        Schema::dropIfExists('siswas');
    }
};
