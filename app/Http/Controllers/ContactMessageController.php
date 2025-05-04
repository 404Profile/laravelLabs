<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactMessageController extends Controller
{
    public function index()
    {
        return Inertia::render('Contact/Index');
    }

    public function store(ContactMessageRequest $request)
    {
        $validated = $request->validated();

        ContactMessage::create($validated);

        return redirect()->route('contact.index')->with('success', 'Ваше сообщение успешно отправлено');
    }
}
