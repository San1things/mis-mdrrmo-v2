<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

// =======================
//     Admin/Users
// =======================
Route::get('/', [UsersController::class, 'index'])->name('adminhomepage');
Route::post('/adduser', [UsersController::class, 'userAdd'])->name('adminadduser');
Route::post('/updateuser', [UsersController::class, 'userUpdate'])->name('adminupdateuser');
Route::post('/deleteuser', [UsersController::class, 'userDelete'])->name('admindeleteuser');
Route::get('/generate-user-pdf', [PDFController::class, 'generateUserPdf'])->name('generate-user-pdf');


// =======================
//     Admin/Inventory
// =======================
Route::get('/inventory', [InventoryController::class, 'index'])->name('admininventory');
Route::post('/additem', [InventoryController::class, 'itemAdd'])->name('adminadditem');
Route::post('/updateitem', [InventoryController::class, 'itemUpdate'])->name('adminupdateitem');
Route::post('/deleteitem', [InventoryController::class, 'itemDelete'])->name('admindeleteitem');


// =======================
//     Admin/Categories
// =======================
Route::get('/categories', [CategoriesController::class, 'index'])->name('admincategories');
