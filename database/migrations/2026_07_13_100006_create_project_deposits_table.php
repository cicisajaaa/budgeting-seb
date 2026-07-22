<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('setoran_proyek', function (Blueprint $table) {


            $table->id();



            $table->foreignId('proyek_id')
                ->constrained('proyek')
                ->cascadeOnDelete();



       $table->unsignedBigInteger('rekening_bank_id')
    ->nullable();



            $table->decimal(
                'jumlah_setoran',
                15,
                2
            );



            $table->date('tanggal_setoran');



            $table->timestamps();


        });

    }





    public function down(): void
    {

        Schema::dropIfExists('setoran_proyek');

    }

};