<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TestAnswer
 *
 * @property int $id
 * @property int user_id
 * @property string data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class TestAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
