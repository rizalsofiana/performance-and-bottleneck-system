<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel audit trail untuk fitur Voice Command (Web Speech API -> n8n webhook).
     * Menyimpan transkrip mentah, intent hasil parsing n8n, parameter query yang
     * dihasilkan, dan jumlah hasil yang dikembalikan ke dashboard.
     */
    public function up(): void
    {
        Schema::create('voice_query_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('User yang mengucapkan perintah suara');

            $table->text('raw_transcript')->comment('Hasil Speech-to-Text mentah dari browser');
            $table->string('parsed_intent', 100)->nullable()->comment('Intent/kata kunci hasil parsing n8n, contoh: overdue_this_week');
            $table->json('query_params')->nullable()->comment('Parameter hasil parsing n8n untuk query (periode, divisi, dll)');
            $table->unsignedInteger('result_count')->nullable()->comment('Jumlah baris/hasil yang dikembalikan ke dashboard');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voice_query_logs');
    }
};
