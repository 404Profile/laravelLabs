<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function createComment(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->text = $request['text'];
        $comment->save();
    }
}
