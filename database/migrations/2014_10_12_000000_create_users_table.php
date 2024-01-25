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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid',36);
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->nullableMorphs('userable');
            $table->enum('role',['owner','sekolah','siswa','guru']);
            $table->boolean('active')->default(0);
            $table->rememberToken();
            $table->timestamps();
            // $table->string('npsn')->nullable();
            // $table->string('nisn')->nullable();
            // $table->string('nip')->nullable();
            
            // $table->foreign('npsn')->references('sekolahs')->on('npsn')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('nisn')->references('siswas')->on('sisn')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('nip')->references('gurus')->on('nip')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('users', function(Blueprint $table) {
        //     $table->dropForeign('npsn');
        //     $table->dropForeign('nisn');
        //     $table->dropForeign('nip');
        // });
        Schema::dropIfExists('users');
    }
};
