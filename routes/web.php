<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PublicController;

Route::view('/welcome', 'welcome')->name('home');

// Why ::get rather than ::view?
Route::get('/', [PublicController::class, 'list']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    // "Route::resource..." adds all seven in one line: 
    //       index, create, store, show, edit, update, destroy
    Route::resource('resources', ResourceController::class); 
});



require __DIR__.'/settings.php';
