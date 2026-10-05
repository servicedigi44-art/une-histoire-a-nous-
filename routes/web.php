<?php

use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FriendController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MemoryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\MusicController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SecureMediaController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// --- Les routes medias les plus specifiques viennent D'ABORD, sinon la
// route generique /media/{media}/{variant?} les intercepte par erreur. ---
Route::get('/media/music', [SecureMediaController::class, 'music'])
    ->middleware('signed')
    ->name('media.music');

Route::get('/media/friend/{friend}/{stage}', [SecureMediaController::class, 'friendPhoto'])
    ->middleware('signed')
    ->name('media.friend-photo');

Route::get('/media/slide/{slide}/{variant?}', [SecureMediaController::class, 'slide'])
    ->middleware('signed')
    ->name('media.slide');

Route::get('/media/{media}/{variant?}', [SecureMediaController::class, 'show'])
    ->middleware('signed')
    ->name('media.show');

Route::middleware('auth')->group(function () {
    Route::get('/', [StoryController::class, 'opening'])->name('story.opening');
    Route::get('/story/play', [StoryController::class, 'play'])->name('story.play');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('slides', [SlideController::class, 'index'])->name('slides.index');
    Route::post('slides', [SlideController::class, 'store'])->name('slides.store');
    Route::put('slides/{slide}', [SlideController::class, 'update'])->name('slides.update');
    Route::delete('slides/{slide}', [SlideController::class, 'destroy'])->name('slides.destroy');
    Route::patch('slides/{slide}/toggle', [SlideController::class, 'toggle'])->name('slides.toggle');
    Route::patch('slides/{slide}/order', [SlideController::class, 'updateOrder'])->name('slides.order');
    Route::post('slides/reorder', [SlideController::class, 'reorder'])->name('slides.reorder');

    Route::post('music', [MusicController::class, 'store'])->name('music.store');
    Route::delete('music', [MusicController::class, 'destroy'])->name('music.destroy');

    Route::resource('chapters', ChapterController::class)->except(['show']);
    Route::patch('chapters/{chapter}/toggle', [ChapterController::class, 'toggle'])->name('chapters.toggle');
    Route::post('chapters/reorder', [ChapterController::class, 'reorder'])->name('chapters.reorder');

    Route::resource('memories', MemoryController::class)->except(['show']);
    Route::patch('memories/{memory}/toggle', [MemoryController::class, 'toggle'])->name('memories.toggle');
    Route::post('memories/reorder', [MemoryController::class, 'reorder'])->name('memories.reorder');

    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::post('media/reorder', [MediaController::class, 'reorder'])->name('media.reorder');

    Route::resource('friends', FriendController::class)->except(['show']);
    Route::patch('friends/{friend}/toggle', [FriendController::class, 'toggle'])->name('friends.toggle');
    Route::post('friends/reorder', [FriendController::class, 'reorder'])->name('friends.reorder');

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
    Route::put('messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::patch('messages/{message}/toggle', [MessageController::class, 'toggle'])->name('messages.toggle');
});