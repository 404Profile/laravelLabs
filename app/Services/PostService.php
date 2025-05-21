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

        if ($request->boolean('remove_photo') && $post->photo_path) {
            Storage::disk('public')->delete($post->photo_path);
            $post->photo_path = null;
        } elseif ($request->hasFile('photo_path')) {
            if ($post->photo_path) {
                Storage::disk('public')->delete($post->photo_path);
            }
            $post->photo_path = Storage::disk('public')->putFile('posts', $request->file('photo_path'));
        }

        $post->update();
    }

    public function deletePost(Post $post): void
    {
        if ($post->photo_path) {
            Storage::disk('public')->delete($post->photo_path);
        }
        $post->delete();
    }

    /**
     * Import posts from a CSV file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return int Count of imported posts
     */
    public function importFromCsv($file): int
    {
        $count = 0;
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if (count($data) >= 2) {
                    $title = $data[0] ?? '';
                    $body = $data[1] ?? '';
                    $imageUrl = $data[2] ?? null;

                    $pathImage = null;

                    if ($imageUrl && filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                        $imageContents = file_get_contents($imageUrl);
                        $filename = basename($imageUrl);
                        $tempPath = sys_get_temp_dir() . '/' . $filename;

                        file_put_contents($tempPath, $imageContents);

                        $pathImage = Storage::disk('public')->putFile('posts', new \Illuminate\Http\File($tempPath));

                        @unlink($tempPath);
                    }

                    $post = new Post();
                    $post->title = $title;
                    $post->body = $body;
                    $post->user_id = Auth::id();
                    $post->photo_path = $pathImage;
                    $post->save();

                    $count++;
                }
            }
            fclose($handle);
        }

        return $count;
    }
}
