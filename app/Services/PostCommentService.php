<?php

namespace App\Services;

use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentService
{
    public function createPostComment(Request $request)
    {
        $comment = new PostComment();
        $comment->body = $request['body'];
        $comment->user_id = Auth::id();
        $comment->post_id = $request['postId'];
        $comment->save();

        return $comment;
    }
}
