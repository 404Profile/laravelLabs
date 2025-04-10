<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visited_at',
        'webpage',
        'ip_address',
        'host_name',
        'browser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
