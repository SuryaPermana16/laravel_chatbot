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
        Schema::create('nomor_antrians', function (Blueprint $table) {
            $table->id();

            $table->integer('nomor_antrian');

            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');
            $table->dateTime('tanggal_antrian')->useCurrent(); 
            $table->enum('status_antrian', ['menunggu', 'diproses', 'selesai'])->default('menunggu');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_antrians');
    }
};