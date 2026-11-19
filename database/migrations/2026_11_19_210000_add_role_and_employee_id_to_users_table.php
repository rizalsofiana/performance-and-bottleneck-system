<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan dukungan RBAC (role) dan relasi akun login ke data karyawan.
     * Dibuat sebagai migration terpisah (bukan mengedit migration users yang
     * sudah berjalan) sesuai best practice Laravel.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['director', 'hr_hod', 'staff'])
                ->default('staff')
                ->after('password')
                ->comment('RBAC: director = L1 (Full Access), hr_hod = L2 (Lead Access), staff = L3 (Staff Access)');

            $table->foreignId('employee_id')
                ->nullable()
                ->unique()
                ->after('role')
                ->constrained('employees')
                ->nullOnDelete()
                ->comment('Relasi akun login ke data karyawan, dipakai untuk scoping data per divisi/PIC');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('employee_id');
            $table->dropColumn('role');
        });
    }
};
