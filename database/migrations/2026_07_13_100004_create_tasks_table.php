<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('tugas', function (Blueprint $table) {


            $table->id();



            $table->foreignId('proyek_id')
                ->constrained('proyek')
                ->cascadeOnDelete();



            $table->foreignId('divisi_id')
                ->constrained('divisi')
                ->cascadeOnDelete();



            $table->foreignId('karyawan_id')
                ->constrained('karyawan')
                ->cascadeOnDelete();



            $table->date('tanggal');



            $table->string('nama_tugas');



            $table->text('aktivitas')
                ->nullable();



            $table->string('prioritas')
                ->default('Low');



            $table->date('deadline')
                ->nullable();



            $table->string('status')
                ->default('belum_dikerjakan');



            $table->decimal(
                'progres_persen',
                5,
                2
            )
            ->default(0);



            $table->text('catatan')
                ->nullable();



            $table->timestamps();


        });

    }





    public function down(): void
    {

        Schema::dropIfExists('tugas');

    }

};