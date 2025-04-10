<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CheckRegisteredController extends Controller
{
    public function checkRegisteredUser(Request $request)
    {
        $user = User::query()->where('email', $request['email'])->count();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
