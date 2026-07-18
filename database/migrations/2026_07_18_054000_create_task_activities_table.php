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
    Schema::create('task_activities', function (Blueprint $table) {

        $table->id();

        $table->foreignId('task_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('employee_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();

        $table->date('tanggal');

        $table->text('aktivitas');

        $table->integer('progress')
              ->default(0);

        $table->decimal('budget_activity', 15, 2)
              ->default(0);

        $table->text('catatan')
              ->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_activities');
    }
};
