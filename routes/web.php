<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('users');
// });

Route::get('/generate-pdf', [PDFController::class, 'generatePdf'])->name('generate-pdf');

Route::get('/', [UsersController::class, 'index'])->name('homepage');

Route::get('/inventory', function() {
    return view('inventory');
});

Route::post('/updateuser', [UsersController::class, 'userUpdate'])->name('updateuser');


