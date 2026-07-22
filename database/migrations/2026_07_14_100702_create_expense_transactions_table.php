<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {


        Schema::create('transaksi_dana', function (Blueprint $table) {


            $table->id();



            /*
            |--------------------------------------------------------------------------
            | Relasi Pengajuan Dana
            |--------------------------------------------------------------------------
            */


            $table->foreignId('pengajuan_dana_id')
                ->constrained('pengajuan_dana')
                ->cascadeOnDelete();




            /*
            |--------------------------------------------------------------------------
            | Relasi Penyetuju
            |--------------------------------------------------------------------------
            */


            $table->foreignId('disetujui_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();




            /*
            |--------------------------------------------------------------------------
            | Relasi Rekening Bank
            |--------------------------------------------------------------------------
            */


            $table->unsignedBigInteger('rekening_bank_id')
                ->nullable();




            $table->decimal(
                'jumlah',
                15,
                2
            );




            $table->date('tanggal');




            $table->timestamps();


        });


    }







    public function down(): void
    {


        Schema::dropIfExists('transaksi_dana');


    }


};