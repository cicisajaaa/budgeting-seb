<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('proyeks', function (Blueprint $table) {

            $table->foreignId('perusahaan_id')
                ->nullable()
                ->after('id')
                ->constrained('perusahaans')
                ->cascadeOnDelete();

        });
    }


    public function down(): void
    {
        Schema::table('proyeks', function (Blueprint $table) {

            $table->dropForeign([
                'perusahaan_id'
            ]);

            $table->dropColumn('perusahaan_id');

        });
    }

};