<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('expense_requests', function (Blueprint $table) {


            $table->id();


            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();



            $table->foreignId('division_id')
                ->constrained()
                ->cascadeOnDelete();



            $table->foreignId('user_id')
                ->constrained()
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



            $table->timestamps();

        });

    }


    public function down(): void
    {

        Schema::dropIfExists('expense_requests');

    }

};