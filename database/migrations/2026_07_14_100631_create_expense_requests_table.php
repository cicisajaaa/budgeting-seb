<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {


        Schema::create('pengajuan_dana', function (Blueprint $table) {


            $table->id();



            $table->foreignId('proyek_id')
                ->constrained('proyek')
                ->cascadeOnDelete();




            $table->foreignId('divisi_id')
                ->constrained('divisi')
                ->cascadeOnDelete();




            $table->foreignId('pengguna_id')
                ->constrained('users')
                ->cascadeOnDelete();




            $table->string('judul');




            $table->text('keterangan')
                ->nullable();




            $table->decimal(
                'jumlah',
                15,
                2
            );




            $table->enum(
                'status',
                [
                    'pending',
                    'approved',
                    'rejected'
                ]
            )
            ->default('pending');




            /*
            |--------------------------------------------------------------------------
            | Informasi Persetujuan
            |--------------------------------------------------------------------------
            */


            $table->foreignId('disetujui_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();




            $table->timestamp('disetujui_pada')
                ->nullable();




            $table->text('catatan_persetujuan')
                ->nullable();




            $table->timestamps();


        });


    }







    public function down(): void
    {


        Schema::dropIfExists('pengajuan_dana');


    }


};