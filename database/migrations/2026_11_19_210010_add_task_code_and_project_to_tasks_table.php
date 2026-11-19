<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan identitas unik tugas (task_code) dan nama proyek (project_name)
     * yang dibutuhkan oleh tabel tugas kritis pada dashboard, serta index
     * komposit untuk mempercepat query cron n8n (scan task overdue setiap 08:00).
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('task_code', 30)->nullable()->unique()->after('id')
                ->comment('Kode unik tugas, contoh: PRJ-2026-081');
            $table->string('project_name', 150)->nullable()->after('title')
                ->comment('Nama proyek terkait tugas, contoh: Portal Core Redesign');

            $table->index(['status', 'due_date'], 'tasks_status_due_date_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_status_due_date_index');
            $table->dropColumn(['task_code', 'project_name']);
        });
    }
};
