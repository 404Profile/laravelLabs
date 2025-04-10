<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int user_id
 * @property string text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'text',
    ];

    protected $casts = [
        'created_at' => 'datetime:D d M Y H:i:s',
        'updated_at' => 'datetime:D d M Y H:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
