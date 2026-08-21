<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('aktivitas_tugas', function (Blueprint $table) {


            $table->id();


            $table->foreignId('tugas_id')
                ->constrained('tugas')
                ->cascadeOnDelete();


            $table->foreignId('karyawan_id')
                ->constrained('karyawan')
                ->cascadeOnDelete();


            $table->date('tanggal');


            $table->text('aktivitas');


            $table->integer('progres')
                ->default(0);


            $table->integer('anggaran_aktivitas')
                ->default(0);


            $table->text('catatan')
                ->nullable();


            $table->timestamps();


        });

    }





    public function down(): void
    {

        Schema::dropIfExists('aktivitas_tugas');

    }

};