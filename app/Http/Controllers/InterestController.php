<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterestRequest;
use App\Http\Requests\UpdateInterestRequest;
use App\Models\Interest;
use App\Services\InterestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Auth::user()->interests()->where('type', Interest::TYPE_FILMS)->latest()->get();
        $music = Auth::user()->interests()->where('type', Interest::TYPE_MUSIC)->latest()->get();
        $walking = Auth::user()->interests()->where('type', Interest::TYPE_WALKING)->latest()->get();

        $interests = [
            'films' => $films,
            'music' => $music,
            'walking' => $walking,
        ];

        return Inertia::render('Interests/Index', [
            'interests' => $interests,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInterestRequest $request, InterestService $interestService)
    {
        $request->validated();
        $interestService->createInterest($request);
        return Redirect::back()->with('success', 'The interest was successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Interest $interest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interest $interest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInterestRequest $request, Interest $interest, InterestService $interestService)
    {
        $request->validated();
        $interestService->updateInterest($request, $interest);
        return Redirect::back()->with('success', 'The interest was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interest $interest)
    {
        $interest->delete();
        return Redirect::back()->with('success', 'The interest was successfully deleted');
    }
}
