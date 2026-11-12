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
        Schema::table('riwayat_pengurangan', function (Blueprint $table) {
            $table->string('shift', 50)->nullable()->after('nama_mekanik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pengurangan', function (Blueprint $table) {
            $table->dropColumn('shift');
        });
    }
};
