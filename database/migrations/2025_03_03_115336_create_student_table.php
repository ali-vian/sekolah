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
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_masuk')->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('asal_sd')->nullable();
            $table->string('asal_smp')->nullable();
            $table->string('nik')->nullable()->number_format();
            $table->string('nisn')->nullable()->number_format();
            $table->string('urut_yayasan')->nullable()->number_format();
            $table->string('urut_jurusan')->nullable()->number_format();
            $table->string('kode_jurusan')->nullable()->number_format();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable()->date_format('d-m-y');
            $table->string('ibu')->nullable();
            $table->string('ayah')->nullable();
            $table->string('alamat')->nullable();
            $table->string('anak_ke')->nullable();
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
