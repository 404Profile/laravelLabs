<?php

namespace App\Http\Controllers;

use App\Actions\ValidateTestAction;
use App\Models\TestAnswer;
use App\Services\TestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testAnswers = TestAnswer::query()->where('user_id', Auth::id())->get();

        return Inertia::render('Test/Index', [
            'testAnswers' => $testAnswers,
        ]);
    }

    public function validateTest(Request $request, TestService $testService)
    {
        $validate = $testService->validateTest($request);

        if ($validate) {
            return Redirect::back()->with('success', 'Test sent');
        } else {
            return Redirect::back()->with('error', 'Test have some errors');
        }
    }
}
