<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AnnouncementsController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\SeminarsController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Resident\ResidentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;


Route::get('/testemaillayout', [PublicController::class, 'tryemail'])->name('testemaillayout');

// =======================
//        Public
// =======================
Route::group(['middleware' => 'havesessionkey'], function () {
    Route::get('/', [PublicController::class, 'home'])->name('home');
    Route::post('/publichomesubscribe', [PublicController::class, 'publicHomeSubscribe'])->name('publichomesubscribe');
    Route::get('/about', [PublicController::class, 'about'])->name('about');
    Route::get('/services', [PublicController::class, 'services'])->name('services');
    Route::get('/faqs', [PublicController::class, 'faqs'])->name('faqs');
    Route::post('/publicfaqsmessage', [PublicController::class, 'publicFaqsMessage'])->name('publicfaqsmessage');
    Route::post('/publicfaqssubscribe', [PublicController::class, 'publicFaqsSubscribe'])->name('publicfaqssubscribe');
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
    //   Admin/Announcements
    // =======================
    Route::get('/adminannouncements', [AnnouncementsController::class, 'index'])->name('adminannouncement');
    Route::post('/adminpostannouncement', [AnnouncementsController::class, 'announcementAdd'])->name('adminpostannouncement');
    Route::post('/adminupdateannouncement', [AnnouncementsController::class, 'announcementUpdate'])->name('adminupdateannouncement');
    // =======================
    //     Admin/Categories
    // =======================
    Route::get('/categories', [InventoryController::class, 'categoriesIndex'])->name('admincategories');
    // =======================
    //     Admin/Seminars
    // =======================
    Route::get('/adminseminars', [SeminarsController::class, 'index'])->name('adminseminars');
    Route::post('/admincreateseminar', [SeminarsController::class, 'createSeminar'])->name('createseminar');
    Route::post('/adminupdateseminar', [SeminarsController::class, 'updateSeminar'])->name('adminupdateseminar');
    Route::get('/seminarcollapseddiv', [SeminarsController::class, 'collapsedDiv'])->name('seminarcollapseddiv');
    Route::post('/adminremoveattendee', [SeminarsController::class, 'adminRemoveAttendee'])->name('adminremoveattendee');
    // =======================
    //   Admin/Subscriptions
    // =======================
    Route::get('/subscriptions', [StaticPageController::class, 'subscriptionsIndex'])->name('adminsubscription');
    Route::post('/adminunsubscribe', [StaticPageController::class, 'adminUnsubscribe'])->name('adminunsubscribe');
    // =======================
    //     Admin/Messages
    // =======================
    Route::get('/adminmessages', [MessagesController::class, 'index'])->name('adminmessages');
    Route::post('/adminmessagereply', [MessagesController::class, 'adminMessageReply'])->name('adminmessagereply');
    // =======================
    //   Admin/Notifications
    // =======================
    Route::get('/adminnotif', [StaticPageController::class, 'adminNotifIndex'])->name('adminnotif');
    Route::get('/adminremovenotif', [StaticPageController::class, 'adminRemoveNotif'])->name('adminremovenotif');
    // =======================
    //     Admin/Logs
    // =======================
    Route::get('/logs', [StaticPageController::class, 'logsIndex'])->name('logs');
    // =======================
    //     Admin/Profile
    // =======================
    Route::get('/adminprofile', [StaticPageController::class, 'adminprofileIndex'])->name('adminprofile');
    Route::post('/adminupdateprofile', [StaticPageController::class, 'adminUpdateProfile'])->name('adminupdateprofile');
    Route::post('/adminupdatepassword', [StaticPageController::class, 'adminUpdatePassword'])->name('adminupdatepasword');



    // =======================
    //     Resident
    // =======================
    Route::get('/userhome', [ResidentController::class, 'userhome'])->name('userhome');
    Route::get('/userabout', [ResidentController::class, 'userabout'])->name('userabout');
    Route::get('/userservices', [ResidentController::class, 'userservices'])->name('userservices');
    Route::get('/userfaqs', [ResidentController::class, 'userfaqs'])->name('userfaqs');
    Route::post('/userfaqsmessage', [ResidentController::class, 'userFaqsMessage'])->name('userfaqsmessage');
    Route::get('/userannouncements', [ResidentController::class, 'userannouncements'])->name('userannouncements');
    Route::get('/userseminars', [ResidentController::class, 'userseminars'])->name('userseminars');
    Route::get('/userjoinseminar', [ResidentController::class, 'userJoinSeminar'])->name('userjoinseminar');
    Route::get('/userunregisterseminar', [ResidentController::class, 'userUnregisterSeminar'])->name('userunregisterseminar');
    Route::get('/userprofile', [ResidentController::class, 'userprofile'])->name('userprofile');
    Route::post('/userupdateprofile', [ResidentController::class, 'userUpdateProfile'])->name('userupdateprofile');
    Route::post('/userupdatepassword', [ResidentController::class, 'userUpdatePassword'])->name('userupdatepassword');
    Route::get('/usernotif', [ResidentController::class, 'usernotif'])->name('usernotif');
    Route::get('/userremovenotif', [ResidentController::class, 'userRemoveNotif'])->name('userremovenotif');
});
