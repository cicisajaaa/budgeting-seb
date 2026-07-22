<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {


        Schema::create('saldo_divisi', function (Blueprint $table) {


            $table->id();



            /*
            |--------------------------------------------------------------------------
            | Relasi Proyek
            |--------------------------------------------------------------------------
            */


            $table->foreignId('proyek_id')
                ->constrained('proyek')
                ->cascadeOnDelete();




            /*
            |--------------------------------------------------------------------------
            | Relasi Divisi
            |--------------------------------------------------------------------------
            */


            $table->foreignId('divisi_id')
                ->constrained('divisi')
                ->cascadeOnDelete();




            $table->decimal(
                'saldo',
                15,
                2
            )
            ->default(0);




            $table->timestamps();




            $table->unique([

                'proyek_id',

                'divisi_id'

            ]);



        });


    }







    public function down(): void
    {


        Schema::dropIfExists('saldo_divisi');


    }


};