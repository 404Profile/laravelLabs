<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_name',
        'score',
        'total_questions',
        'passed',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
