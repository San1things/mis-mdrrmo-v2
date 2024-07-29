<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('users');
// });

Route::get('/generate-user-pdf', [PDFController::class, 'generateUserPdf'])->name('generate-user-pdf');

Route::get('/', [UsersController::class, 'index'])->name('adminhomepage');

Route::get('/inventory', [InventoryController::class, 'index'])->name('admininventory');

Route::post('/updateuser', [UsersController::class, 'userUpdate'])->name('updateuser');


