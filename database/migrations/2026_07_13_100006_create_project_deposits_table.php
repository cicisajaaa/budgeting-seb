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
        Schema::create('project_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->decimal('jumlah_setoran', 15, 2);
            $table->date('tanggal_setoran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_deposits');
    }
};
