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
        Schema::create('token_aktivasis', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('email');

            $table->foreign('email')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('token_aktivasis', function(Blueprint $table) {
            $table->dropForeign('email');
        });
        Schema::dropIfExists('token_aktivasis');
    }
};
