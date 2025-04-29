<?php

namespace App\Services;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestService
{
    public function createInterest(Request $request): Interest
    {
        $interest = new Interest();
        $interest->title = $request['title'];
        $interest->type = $request['type'];
        $interest->description = $request['description'];
        $interest->user_id = Auth::id();
        $interest->save();

        return $interest;
    }
}
