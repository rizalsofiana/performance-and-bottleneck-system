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
        Schema::create('bottleneck_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')
                ->constrained('tasks')
                ->onDelete('cascade')
                ->comment('Foreign key ke tabel tasks yang bermasalah');

            $table->enum('escalation_level', ['warning_sent', 'pdf_generated', 'resolved'])
                ->comment('Jenis eskalasi/tindakan sistem');

            $table->string('channel_used', 30)->comment('Saluran yang dipakai: Telegram, Email, dll');
            $table->text('message_payload')->nullable()->comment('Isi ringkas pesan atau keterangan file PDF yang dibuat');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bottleneck_logs');
    }
};
