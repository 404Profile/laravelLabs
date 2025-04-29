<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuestBookController extends Controller
{
    public function index()
    {
        $guestBooks = GuestBook::latest()->paginate(10);

        return Inertia::render('GuestBook', [
            'guestBooks' => $guestBooks,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
        ]);

        GuestBook::create($validated);

        return redirect()->back()->with('success', 'Запись добавлена успешно!');
    }
}
