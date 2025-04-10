<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function createPost(Request $request): void
    {
        $pathImage = null;
        if ($request->hasFile('photo_path')) {
            $pathImage = Storage::disk('public')->putFile('posts', $request->file('photo_path'));
        }

        $post = new Post();
        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->user_id = Auth::id();
        $post->photo_path = $pathImage;
        $post->save();
    }

    public function updatePost(Request $request, Post $post)
    {
        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->update();
    }

    public function deletePost(Post $post): void
    {
        Storage::disk('public')->delete($post->photo_path);
        $post->delete();
    }
}
