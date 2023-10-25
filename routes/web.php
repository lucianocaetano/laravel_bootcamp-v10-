<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Chirp;
use App\Http\Controllers\ChirpController;
require __DIR__.'/auth.php';

Route::view("/", "welcome");
/*
Route::get("/chirp/{chirp?}", function ($chirp = null) {
    
    if ($chirp == 2){
        return to_route("chirps.index"); // lo mismo que redirect()->route()
    }

    return "hola :D ".$chirp;

})->name("chirps");
 */      
Route::get('/dashboard', function () {

    return view("dashboard");
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/chirps", [ChirpController::class, "index"])->name("chirps.index");

    Route::post("/chirps", [ChirpController::class, "store"])->name("chirps.store"); 
    Route::get("/chirps/{chirp}/edit", [ChirpController::class, "edit"])->name("chrips.edit");
    Route::put("/chirps/{chirp}/update", 
        [ChirpController::class, "update"]
    )->name("chirps.update");
    Route::delete("/chirps/{chirp}/delete", 
        [ChirpController::class, "destroy"]
    )->name("chirps.destroy");
});

