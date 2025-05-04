<?php

namespace App\Http\Controllers;

use App\Actions\ValidateTestAction;
use App\Models\TestAnswer;
use App\Models\TestResult;
use App\Models\User;
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
        $user = Auth::user();

        if ($user->hasRole(User::USER_ADMIN)) {
            $testAnswers = TestAnswer::query()->get();
        } else {
            $testAnswers = TestAnswer::query()->where('user_id', Auth::id())->get();
        }

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
