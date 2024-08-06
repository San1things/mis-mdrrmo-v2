<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// =======================
//        Public
// =======================
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/faqs', [PublicController::class, 'faqs'])->name('faqs');
Route::get('/announcements', [PublicController::class, 'announcements'])->name('announcements');
Route::get('/login', [LoginController::class, 'login'])->name('loginpage');
Route::get('/register', [LoginController::class, 'register'])->name('registerpage');


// =======================
//     Admin/Users
// =======================
Route::get('/users', [UsersController::class, 'index'])->name('adminhomepage');
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
