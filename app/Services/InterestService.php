<?php

namespace App\Services;

use App\Models\Interest;
use Illuminate\Http\Request;

class InterestService
{
    public function createInterest(Request $request): Interest
    {
        $interest = new Interest();
        $interest->title = $request['title'];
        $interest->type = $request['type'];
        $interest->description = $request['description'];
        $interest->save();

        return $interest;
    }
}
