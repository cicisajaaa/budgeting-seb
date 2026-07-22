<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('alokasi_proyek_divisi', function (Blueprint $table) {


            $table->id();



            $table->foreignId('proyek_id')
                ->constrained('proyek')
                ->cascadeOnDelete();



            $table->foreignId('divisi_id')
                ->constrained('divisi')
                ->cascadeOnDelete();



            $table->decimal(
                'persentase',
                5,
                2
            );



            $table->timestamps();


        });

    }





    public function down(): void
    {

        Schema::dropIfExists('alokasi_proyek_divisi');

    }

};