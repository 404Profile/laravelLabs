<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Photo
 *
 * @property int $id
 * @property string $title
 * @property string $photo_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'photo_path'
    ];
}
