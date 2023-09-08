<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;

/* HOME */
Route :: get("/", [ApartmentController :: class, "index"]);

/* SHOW */
Route :: get("/show/{id}", [ApartmentController :: class, "show"])
-> name("apartment.show");

/* CREATE APARTMENT */
Route :: get("/create", [ApartmentController :: class,
"create"])
-> middleware(['auth', 'verified'])
-> name("apartment.create");

/* STORE APPARTMENT */
Route :: post("/apartment_store", [ApartmentController :: class, "store"]) -> name("apartment.store");


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
