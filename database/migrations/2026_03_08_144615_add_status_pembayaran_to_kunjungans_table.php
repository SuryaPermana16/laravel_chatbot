<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Menambahkan kolom status_pembayaran, taruh setelah kolom 'total_bayar'
            $table->string('status_pembayaran', 50)->nullable()->default('Lunas')->after('total_bayar');
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('status_pembayaran');
        });
    }
};
