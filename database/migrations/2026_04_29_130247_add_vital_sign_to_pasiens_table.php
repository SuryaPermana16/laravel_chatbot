<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->integer('berat_badan')->nullable()->after('no_telepon');
            $table->integer('tinggi_badan')->nullable()->after('berat_badan');
            $table->string('tensi_darah')->nullable()->after('tinggi_badan');
        });
    }

    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn([
                'berat_badan',
                'tinggi_badan',
                'tensi_darah'
            ]);
        });
    }
};