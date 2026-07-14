<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('expense_transactions', function (Blueprint $table) {


            $table->id();


            $table->foreignId('request_id')
                ->constrained('expense_requests')
                ->cascadeOnDelete();



            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users');



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

        Schema::dropIfExists('expense_transactions');

    }

};