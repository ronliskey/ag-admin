<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;

Route::view('/', 'welcome')->name('home');

// "Route::resource..." adds all seven in one line: 
//    index, create, store, show, edit, update, destroy
Route::resource('resources', ResourceController::class); 


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    // Route::view('resources', 'resources')->name('resources');
    Route::get('add-resource', [ResourceController::class, 'index']);
    // Route::post('store', [ResourceController::class, 'store']);
});



require __DIR__.'/settings.php';
