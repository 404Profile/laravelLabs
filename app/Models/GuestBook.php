<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GuestBook
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $author_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class GuestBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author_name',
    ];
}
