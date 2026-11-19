<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Index pada kolom department untuk mempercepat query agregasi grafik
     * "Distribusi Hambatan per Divisi" pada dashboard.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->index('department', 'employees_department_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex('employees_department_index');
        });
    }
};
