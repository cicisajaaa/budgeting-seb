<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('division_balances', function (Blueprint $table) {


            $table->id();


            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();



            $table->foreignId('division_id')
                ->constrained()
                ->cascadeOnDelete();



            $table->decimal(
                'saldo',
                15,
                2
            )
            ->default(0);



            $table->timestamps();


            $table->unique([
                'project_id',
                'division_id'
            ]);


        });

    }


    public function down(): void
    {

        Schema::dropIfExists('division_balances');

    }

};