<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $posts = Post::query()->with(['user', 'comments.user'])->orderByDesc('id')->paginate(9);

        return Inertia::render('Welcome', [
            'posts' => $posts,
        ]);
    }
}
