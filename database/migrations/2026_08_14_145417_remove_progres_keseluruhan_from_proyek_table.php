<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('proyek', function (Blueprint $table) {

            $table->dropColumn('progres_keseluruhan');

        });
    }


    public function down(): void
    {
        Schema::table('proyek', function (Blueprint $table) {

            $table->decimal(
                'progres_keseluruhan',
                5,
                2
            )
            ->default(0);

        });
    }

};