<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\AutocompleteController;

/* HOME */
Route :: get("/", [ApartmentController :: class, "index"]);

/* DASHBOARD */
Route::get('/dashboard', [ApartmentController :: class, "dashboard"])->middleware(['auth', 'verified'])
->name('dashboard');

/* SHOW */
Route :: get("/show/{id}", [ApartmentController :: class, "show"])
-> name("apartment.show");

/* SEARCH PAGE*/
Route::post('/search', [ApartmentController :: class, "search"])->name('search');

/* UPDATE RADIUS */
Route::post('/updateRadius', [ApartmentController :: class, "updateRadius"])->name('updateRadius');

/* CREATE APARTMENT */
Route :: get("/create", [ApartmentController :: class,
"create"])
-> middleware(['auth', 'verified'])
-> name("apartment.create");

/* STORE APPARTMENT */
Route :: post("/apartment_store", [ApartmentController :: class, "store"]) -> name("apartment.store");

// EDIT APARTMENT
Route :: get ('/edit/{id}', [ApartmentController :: class, "edit"]) -> name("apartment.edit");

// UPDATE APARTMENT
Route :: put ('/update/{id}', [ApartmentController :: class, "update"]) -> name("apartment.update");

// DELETE APARTMENT
Route :: delete ('/delete/{id}', [ApartmentController :: class, "delete"]) -> name("apartment.delete");

// -----------------------------------------------------------------
//TOM TOM

//SearchApi
Route::post('/searchApi', [ApartmentController::class, 'searchApi']) -> name("searchApi");

//Autocomplete
Route::get('/autocomplete', [AutocompleteController::class, 'autocompleteApi']) -> name("autocompleteApi");

// MESSAGE

    // CREATE
Route :: get("/messagePage/{id}", [ApartmentController :: class, "messagePage"]) -> name("messagePage");

    // STORE
Route :: post("/messageStore/{id}", [ApartmentController :: class, "messageStore"]) -> name("message.store");

// CREO LA ROTTA PER APARTMENT.MESSAGE
Route :: get("/messageApartment", [ApartmentController :: class, "messageApartment"]) -> name("messageApartment");

// // ROTTA PER LE STATISTICHE
// Route :: get("/statistics", [ApartmentController :: class, "statistics"]) -> name("statistics");

// ROTTA SPONSOR
    // SPONSOR FORM
    Route::get('/apartment/{id}/sponsor', [ApartmentController::class, 'showSponsorshipForm'])->name('sponsor-form');
    // APPLICA SPONSOR
        // Process the sponsorship form
        Route::post('/apartment/{id}/sponsor', [ApartmentController::class, 'applySponsorship'])->name('apply-sponsorship');




// -----------------------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
