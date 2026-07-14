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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            
            $table->date('tanggal')->nullable();
            $table->string('nama_task');
            $table->text('aktivitas');
            $table->enum('prioritas', ['Low', 'Medium', 'High']);
            $table->date('deadline')->nullable();
            $table->string('status'); 
            $table->decimal('progress_persen', 5, 2)->default(0);
            $table->text('catatan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
