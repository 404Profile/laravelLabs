<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $visits = Visit::query()->orderByDesc('id')->paginate(10);

        return Inertia::render('Dashboard', [
            'visits' => $visits,
        ]);
    }
}
