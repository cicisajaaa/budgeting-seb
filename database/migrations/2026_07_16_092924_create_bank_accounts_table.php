<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {

        Schema::create('rekening_bank', function (Blueprint $table) {


            $table->id();


            $table->string('nama_bank');


            $table->string('nomor_rekening')
                ->unique();



            $table->string('nama_pemilik');



            $table->decimal(
                'saldo',
                15,
                2
            )
            ->default(0);



            $table->boolean('status')
                ->default(true);



            $table->timestamps();


        });

    }




    public function down(): void
    {

        Schema::dropIfExists('rekening_bank');

    }

};