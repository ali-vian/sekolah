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
        // Schema::create('absenguru', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('jadwal_id')->constrained('jadwal');
        //     $table->foreignId('guru_id')->constrained('users');
        //     $table->string('status');
        //     $table->string('keterangan')->nullable();
        //     $table->dateTime('waktu_absen');
        //     $table->timestamps();
        // });
        Schema::create('absenguru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('waktu_absen');
            $table->foreignId('tapel_id')->constrained('tapels')->onDelete('cascade');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alfa']);
            $table->timestamps();

            // Agar satu guru hanya bisa absen 1x per hari untuk tapel tertentu
            $table->unique(['guru_id', 'waktu_absen', 'tapel_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absenguru');
    }
};
