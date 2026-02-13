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
        // 1. Tambah tarif ke tabel Dokter
        Schema::table('dokters', function (Blueprint $table) {
            $table->integer('harga_jasa')->default(50000)->after('spesialis'); // Default 50rb
        });

        // 2. Tambah rincian biaya ke tabel Kunjungan
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->integer('biaya_jasa_dokter')->default(0)->after('resep_obat');
            $table->integer('biaya_obat')->default(0)->after('biaya_jasa_dokter');
            $table->integer('total_bayar')->default(0)->after('biaya_obat');
        });
    }

    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn('harga_jasa');
        });
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn(['biaya_jasa_dokter', 'biaya_obat', 'total_bayar']);
        });
    }
};
