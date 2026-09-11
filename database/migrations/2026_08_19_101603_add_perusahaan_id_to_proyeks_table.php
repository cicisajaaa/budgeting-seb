<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    if (Schema::hasTable('proyeks') &&
        !Schema::hasColumn('proyeks', 'perusahaan_id')) {

        Schema::table('proyeks', function (Blueprint $table) {

            $table->unsignedBigInteger('perusahaan_id')
                  ->nullable()
                  ->after('id');

        });

    }
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