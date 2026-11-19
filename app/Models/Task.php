<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_code',
        'title',
        'project_name',
        'description',
        'employee_id',
        'assigned_date',
        'due_date',
        'completion_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'assigned_date' => 'date',
            'due_date' => 'date',
            'completion_date' => 'date',
        ];
    }

    /**
     * Karyawan (PIC) yang bertanggung jawab atas tugas ini.
     *
     * @return BelongsTo<Employee, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Histori eskalasi bottleneck untuk tugas ini.
     *
     * @return HasMany<BottleneckLog, $this>
     */
    public function bottleneckLogs(): HasMany
    {
        return $this->hasMany(BottleneckLog::class);
    }
}
