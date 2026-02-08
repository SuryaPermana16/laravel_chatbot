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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id(); 

            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');

            $table->integer('total_biaya');
            $table->integer('jumlah_bayar')->nullable();
            $table->integer('kembalian')->nullable();    

            $table->enum('status_pembayaran', ['lunas', 'belum_lunas'])->default('belum_lunas');
            
            $table->string('metode_pembayaran')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};