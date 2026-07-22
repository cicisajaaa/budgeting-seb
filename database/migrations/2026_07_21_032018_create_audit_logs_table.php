<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('log_audit', function (Blueprint $table) {


            $table->id();



            $table->foreignId('pengguna_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();




            $table->string('aksi');



            $table->string('modul');



            $table->text('deskripsi')
                ->nullable();




            $table->string('alamat_ip')
                ->nullable();




            $table->timestamps();


        });

    }




    public function down(): void
    {

        Schema::dropIfExists('log_audit');

    }

};