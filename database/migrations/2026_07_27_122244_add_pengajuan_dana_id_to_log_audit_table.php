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
    Schema::table('log_audit', function (Blueprint $table) {

        $table->foreignId('pengajuan_dana_id')
            ->nullable()
            ->after('pengguna_id')
            ->constrained('pengajuan_dana')
            ->nullOnDelete();

    });
}


public function down(): void
{
    Schema::table('log_audit', function (Blueprint $table) {

        $table->dropForeign([
            'pengajuan_dana_id'
        ]);

        $table->dropColumn(
            'pengajuan_dana_id'
        );

    });
}
};
