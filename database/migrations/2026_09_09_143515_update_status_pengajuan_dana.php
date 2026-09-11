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
       Schema::table('pengajuan_dana', function (Blueprint $table) {

    $table->dropColumn('status');

});


Schema::table('pengajuan_dana', function (Blueprint $table) {

    $table->enum('status', [

        'pending',
        'approved',
        'rejected',
        'dicairkan',
        'selesai'

    ])
    ->default('pending');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
