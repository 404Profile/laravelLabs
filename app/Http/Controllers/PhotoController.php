<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::query()->paginate(9);

        return Inertia::render('Photos/Index', [
            'photos' => $photos,
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
    public function store(StorePhotoRequest $request, PhotoService $photoService)
    {
        $request->validated();
        $photoService->createPhoto($request);
        return Redirect::back()->with('success', 'The photo was successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoRequest $request, Photo $photo, PhotoService $photoService)
    {
        $request->validated();
        $photoService->updatePhoto($request, $photo);
        return Redirect::back()->with('success', 'The photo was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo, PhotoService $photoService)
    {
        $photoService->deletePhoto($photo);
        return Redirect::back()->with('success', 'The photo was successfully deleted');
    }
}
