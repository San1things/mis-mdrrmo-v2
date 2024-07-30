<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// =======================
//     Admin/Users
// =======================
Route::get('/', [UsersController::class, 'index'])->name('adminhomepage');
Route::post('/updateuser', [UsersController::class, 'userUpdate'])->name('adminupdateuser');
Route::post('/deleteuser', [UsersController::class, 'userDelete'])->name('admindeleteuser');
Route::post('/adduser', [UsersController::class, 'userAdd'])->name('adminadduser');
Route::get('/generate-user-pdf', [PDFController::class, 'generateUserPdf'])->name('generate-user-pdf');

// =======================
//     Admin/Users
// =======================
Route::get('/inventory', [InventoryController::class, 'index'])->name('admininventory');
