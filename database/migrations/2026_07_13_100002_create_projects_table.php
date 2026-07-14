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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('nama_project'); 
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('project_owner')->nullable();
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('progress_keseluruhan', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
