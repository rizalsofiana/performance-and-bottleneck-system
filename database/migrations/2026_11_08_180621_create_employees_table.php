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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 30)->unique()->comment('Nomor Induk Karyawan');
            $table->string('name', 100)->comment('Nama lengkap karyawan');
            $table->string('department', 50)->comment('Contoh: IT, Marketing, Sales, HR');
            $table->string('position', 50)->comment('Jabatan karyawan');
            $table->string('email', 100)->unique();
            $table->string('telegram_chat_id', 50)->nullable()->comment('ID Telegram untuk integrasi bot/notifikasi');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
