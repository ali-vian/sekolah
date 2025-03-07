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
        //
        Schema::create('about', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('image');
            $table->json('fasilitas')->nullable();
            $table->text('sambutan');
            $table->string('gambar_sambutan');
            $table->text('sejarah');
            $table->string('gambar_sejarah');
            $table->text('visi');
            $table->string('gambar_visi');
            $table->text('misi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('about');
    }
};
