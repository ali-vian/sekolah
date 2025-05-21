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
        Schema::create('absenharian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student');
            $table->string('status');
            $table->dateTime('waktu_absen');
            $table->foreignId('tapel_id')->constrained('tapels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absenharian');
    }
};
