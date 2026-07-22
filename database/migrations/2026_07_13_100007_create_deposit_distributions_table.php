<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {

        Schema::create('distribusi_setoran', function (Blueprint $table) {


            $table->id();



            $table->foreignId('setoran_proyek_id')
                ->constrained('setoran_proyek')
                ->cascadeOnDelete();



            $table->foreignId('divisi_id')
                ->constrained('divisi')
                ->cascadeOnDelete();



            $table->decimal(
                'nominal_diterima',
                15,
                2
            );



            $table->timestamps();


        });

    }





    public function down(): void
    {

        Schema::dropIfExists('distribusi_setoran');

    }


};