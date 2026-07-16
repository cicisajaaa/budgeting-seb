<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {


        Schema::table('expense_transactions', function (Blueprint $table) {


            $table->foreignId('bank_account_id')
                ->nullable()
                ->after('approved_by');


        });


    }






    public function down(): void
    {


        Schema::table('expense_transactions', function (Blueprint $table) {


            $table->dropColumn(
                'bank_account_id'
            );


        });


    }


};