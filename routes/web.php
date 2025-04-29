<?php

use App\Http\Controllers\CheckRegisteredController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\LogVisit;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([LogVisit::class])->group(function () {
    Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
    Route::post('checkRegisteredUser', [CheckRegisteredController::class, 'checkRegisteredUser'])->name('checkRegisteredUser');
    Route::post('createPostComment', [PostCommentController::class, 'store'])->name('postComment.store');

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('test', [TestController::class, 'index'])->name('test.index');
        Route::resource('interests', InterestController::class);
        Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
        Route::post('storeComment', [CommentController::class, 'store'])->name('comments.store');
        Route::post('validateTest', [TestController::class, 'validateTest'])->name('test.validate');
        Route::resource('photos', PhotoController::class);

        Route::get('/table', function () {
            return Inertia::render('Table');
        })->name('table');;
    });

    Route::middleware([CheckAdminRole::class, 'auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::resource('posts', PostController::class);
    });
});

Route::get('/guest-book', [GuestBookController::class, 'index'])->name('guest-book.index');
Route::post('/guest-book', [GuestBookController::class, 'store'])->name('guest-book.store');
