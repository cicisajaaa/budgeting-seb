<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {


        /*
        |--------------------------------------------------------------------------
        | FIX TABEL TUGAS
        |--------------------------------------------------------------------------
        */


        Schema::table('tugas', function (Blueprint $table) {


            $table->decimal(
                'progres_persen',
                5,
                2
            )
            ->default(0)
            ->change();



            $table->index('karyawan_id');

            $table->index('deadline');

            $table->index('status');


        });





        /*
        |--------------------------------------------------------------------------
        | FIX TABEL AKTIVITAS TUGAS
        |--------------------------------------------------------------------------
        */


        Schema::table('aktivitas_tugas', function (Blueprint $table) {


            $table->integer('progres')
                ->default(0)
                ->change();



            $table->index('tugas_id');

            $table->index('tanggal');


        });


    }





    public function down(): void
    {


        Schema::table('tugas', function (Blueprint $table) {


            $table->dropIndex([
                'karyawan_id'
            ]);


            $table->dropIndex([
                'deadline'
            ]);


            $table->dropIndex([
                'status'
            ]);


        });




        Schema::table('aktivitas_tugas', function (Blueprint $table) {


            $table->dropIndex([
                'tugas_id'
            ]);


            $table->dropIndex([
                'tanggal'
            ]);


        });


    }

};