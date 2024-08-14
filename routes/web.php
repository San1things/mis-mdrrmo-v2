<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AnnouncementsController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Resident\ResidentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'havesessionkey'], function () {
    // =======================
    //        Public
    // =======================
    Route::get('/', [PublicController::class, 'home'])->name('home');
    Route::get('/about', [PublicController::class, 'about'])->name('about');
    Route::get('/services', [PublicController::class, 'services'])->name('services');
    Route::get('/faqs', [PublicController::class, 'faqs'])->name('faqs');
    Route::get('/announcements', [PublicController::class, 'announcements'])->name('announcements');
    Route::get('/login', [LoginController::class, 'login'])->name('loginpage')->middleware('havesessionkey');
    Route::post('/loginprocess', [LoginController::class, 'loginProcess'])->name('loginprocess');
    Route::get('/register', [LoginController::class, 'register'])->name('registerpage');
    Route::post('/registerprocess', [LoginController::class, 'registerProcess'])->name('registerprocess');
});



Route::group(['middleware' => 'loginhandler'], function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    // =======================
    //     Admin/Users
    // =======================
    Route::get('/users', [UsersController::class, 'index'])->name('adminhomepage');
    Route::post('/adduser', [UsersController::class, 'userAdd'])->name('adminadduser');
    Route::post('/updateuserdetails', [UsersController::class, 'userUpdateDetails'])->name('adminupdateuserdetails');
    Route::post('/updateuserpassword', [UsersController::class, 'userUpdatePassword'])->name('adminupdateuserpassword');
    Route::post('/lockuser', [UsersController::class, 'userLock'])->name('adminlockuser');
    Route::post('/unlockuser', [UsersController::class, 'userUnlock'])->name('adminunlockuser');
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
    Route::get('/adminannouncements', [AnnouncementsController::class, 'index'])->name('adminannouncement');
    // =======================
    //     Admin/Categories
    // =======================
    Route::get('/categories', [CategoriesController::class, 'index'])->name('admincategories');
    // =======================
    //     Admin/Logs
    // =======================
    Route::get('/logs', [LogsController::class, 'index'])->name('adminlogs');




    // =======================
    //     Resident
    // =======================
    Route::get('/userhome', [ResidentController::class, 'userhome'])->name('userhome');
    Route::get('/userabout', [ResidentController::class, 'userabout'])->name('userabout');
    Route::get('/userservices', [ResidentController::class, 'userservices'])->name('userservices');
    Route::get('/userfaqs', [ResidentController::class, 'userfaqs'])->name('userfaqs');
    Route::get('/userannouncements', [ResidentController::class, 'userannouncements'])->name('userannouncements');
    Route::get('/userseminars', [ResidentController::class, 'userseminars'])->name('userseminars');
    Route::get('/userprofile', [ResidentController::class, 'userprofile'])->name('userprofile');
    Route::get('/usernotif', [ResidentController::class, 'usernotif'])->name('usernotif');
});
