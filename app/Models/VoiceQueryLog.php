<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'raw_transcript', 'parsed_intent', 'query_params', 'result_count', 'created_at'])]
#[Table('voice_query_logs')]
class VoiceQueryLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'raw_transcript',
        'parsed_intent',
        'query_params',
        'result_count',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'query_params' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * User yang mengucapkan perintah suara.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
