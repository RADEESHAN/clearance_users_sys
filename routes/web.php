<?php

use App\Http\Controllers\MAController;
use Illuminate\Support\Facades\Route;

// Route to display MA data
Route::get('/ma', [MAController::class, 'showMAData'])->name('show.ma');
Route::get('/ma-data', [MAController::class, 'showMAData']);
Route::post('/import', [MAController::class, 'import'])->name('users.import');
Route::get('/import-users-form', function () {
    return view('import');
})->name('users.import.form');




// web.php
Route::post('/approve-clearance', [MAController::class, 'approveClearance']);
Route::post('/decline-clearance', [MAController::class, 'declineClearance']);
Route::get('/clearance', [MAController::class, 'showClearanceRequests']);



?>
