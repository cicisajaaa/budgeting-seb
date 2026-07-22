<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('proyek', function (Blueprint $table) {


            $table->id();


            $table->string('nama_proyek');


            $table->date('tanggal_mulai')
                ->nullable();


            $table->date('tanggal_selesai')
                ->nullable();


            $table->string('pemilik_proyek')
                ->nullable();


            $table->decimal(
                'total_anggaran',
                15,
                2
            )
            ->default(0);



            $table->decimal(
                'progres_keseluruhan',
                5,
                2
            )
            ->default(0);



            $table->timestamps();


        });

    }



    public function down(): void
    {

        Schema::dropIfExists('proyek');

    }

};