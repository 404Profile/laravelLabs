<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Interest
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $type
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Interest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
        'user_id',
    ];

    const TYPE_FILMS = 0;
    const TYPE_MUSIC = 1;
    const TYPE_WALKING = 2;

    public function isFilmsType(): bool
    {
        return $this->type === self::TYPE_FILMS;
    }

    public function isMusicType(): bool
    {
        return $this->type === self::TYPE_MUSIC;
    }

    public function isWalkType(): bool
    {
        return $this->type === self::TYPE_WALKING;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
