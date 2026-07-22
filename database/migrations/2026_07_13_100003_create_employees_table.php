<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('karyawan', function(Blueprint $table){

    $table->id();


    $table->foreignId('pengguna_id')
        ->constrained('users')
        ->cascadeOnDelete();


    $table->string('nama_karyawan');


    $table->foreignId('divisi_id')
        ->constrained('divisi')
        ->cascadeOnDelete();


    $table->timestamps();

});
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
