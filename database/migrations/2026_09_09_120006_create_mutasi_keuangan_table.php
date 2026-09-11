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
    Schema::create('mutasi_keuangan', function (Blueprint $table) {

        $table->id();

        $table->foreignId('rekening_bank_id')
            ->constrained('rekening_bank')
            ->cascadeOnDelete();

        $table->enum('jenis', [
            'masuk',
            'keluar'
        ]);

        $table->decimal('nominal', 15, 2);

        $table->string('referensi_type')->nullable();

        $table->unsignedBigInteger('referensi_id')->nullable();

        $table->date('tanggal');

        $table->text('keterangan')->nullable();

        $table->foreignId('created_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_keuangan');
    }
};
