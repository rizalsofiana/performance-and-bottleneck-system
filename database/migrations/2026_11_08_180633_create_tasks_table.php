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
            $table->string('title', 150)->comment('Judul atau nama tugas');
            $table->text('description')->nullable()->comment('Deskripsi detail tugas');

            // Foreign key ke tabel employees dengan cascade delete
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('cascade')
                ->comment('Foreign key ke tabel employees');

            $table->date('assigned_date')->comment('Tanggal tugas diberikan');
            $table->date('due_date')->comment('Batas waktu penyelesaian (Deadline)');
            $table->date('completion_date')->nullable()->comment('Tanggal aktual tugas diselesaikan');

            $table->enum('status', ['pending', 'in_progress', 'completed', 'overdue'])
                ->default('pending')
                ->comment('Status pengerjaan task');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
