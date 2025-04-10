<?php

use App\Http\Controllers\CheckRegisteredController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\LogVisit;
use Illuminate\Support\Facades\Route;

Route::middleware([LogVisit::class])->group(function () {
    Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
    Route::post('checkRegisteredUser', [CheckRegisteredController::class, 'checkRegisteredUser'])->name('checkRegisteredUser');
    Route::post('createPostComment', [PostCommentController::class, 'store'])->name('postComment.store');

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('test', [TestController::class, 'index'])->name('test.index');
    });

    Route::middleware([CheckAdminRole::class, 'auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::resource('photos', PhotoController::class);
        Route::resource('interests', InterestController::class);
        Route::post('validateTest', [TestController::class, 'validateTest'])->name('test.validate');
        Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
        Route::post('storeComment', [CommentController::class, 'store'])->name('comments.store');
        Route::resource('posts', PostController::class);
    });
});
