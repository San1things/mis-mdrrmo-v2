<?php

use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AnnouncementsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\SeminarsController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Resident\ResidentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\ReportsController;
use Illuminate\Support\Facades\Route;


// Route::get('/testemaillayout', [PublicController::class, 'tryemail'])->name('testemaillayout');

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
    Route::get('/report', [PublicController::class, 'report'])->name('report');
    Route::post('/publicreportprocess', [PublicController::class, 'publicReportProcess'])->name('publicreportprocess');
    Route::get('/login', [LoginController::class, 'login'])->name('loginpage')->middleware('havesessionkey');
    Route::post('/loginprocess', [LoginController::class, 'loginProcess'])->name('loginprocess');
    Route::get('/register', [LoginController::class, 'register'])->name('registerpage');
    Route::post('/registerprocess', [LoginController::class, 'registerProcess'])->name('registerprocess');
    Route::get('/verification', [LoginController::class, 'verificationIndex'])->name('verification');
    Route::post('/verificationprocess', [LoginController::class, 'verificationProcess'])->name('verificationprocess');
    Route::get('/requestotp', [LoginController::class, 'requestOTP'])->name('requestotp');
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
    Route::get('/generate-inventory-pdf', [PDFController::class, 'generateInventoryPdf'])->name('generate-inventory-pdf');
    // =======================
    //   Admin/Announcements
    // =======================
    Route::get('/adminannouncements', [AnnouncementsController::class, 'index'])->name('adminannouncement');
    Route::post('/adminpostannouncement', [AnnouncementsController::class, 'announcementAdd'])->name('adminpostannouncement');
    Route::post('/adminupdateannouncement', [AnnouncementsController::class, 'announcementUpdate'])->name('adminupdateannouncement');
    Route::post('/admindeleteannouncement', [AnnouncementsController::class, 'announcementDelete'])->name('admindeleteannouncement');
    // =======================
    //     Admin/Categories
    // =======================
    Route::get('/categories', [InventoryController::class, 'categoriesIndex'])->name('admincategories');
    Route::post('/createcategory', [InventoryController::class, 'createCategory'])->name('createcategory');
    Route::post('/updatecategory', [InventoryController::class, 'updateCategory'])->name('updatecategory');
    Route::post('/deletecategory', [InventoryController::class, 'deleteCategory'])->name('deletecategory');
    // =======================
    //     Admin/Seminars
    // =======================
    Route::get('/adminseminars', [SeminarsController::class, 'upcomingIndex'])->name('adminseminars');
    Route::post('/admincreateseminar', [SeminarsController::class, 'createSeminar'])->name('createseminar');
    Route::post('/adminupdateseminar', [SeminarsController::class, 'updateSeminar'])->name('adminupdateseminar');
    Route::post('/adminstartseminar', [SeminarsController::class, 'startSeminar'])->name('adminstartseminar');
    Route::post('/adminendseminar', [SeminarsController::class, 'endSeminar'])->name('adminendseminar');
    Route::post('/admincancelseminar', [SeminarsController::class, 'cancelSeminar'])->name('admincancelseminar');
    Route::get('/seminarcollapseddiv', [SeminarsController::class, 'seminarCollapsedDiv'])->name('seminarcollapseddiv');
    Route::post('/adminremoveattendee', [SeminarsController::class, 'adminRemoveAttendee'])->name('adminremoveattendee');
    Route::get('/adminhistory', [SeminarsController::class, 'historyIndex'])->name('adminhistory');
    Route::get('/historycollapseddiv', [SeminarsController::class, 'historyCollapsedDiv'])->name('historycollapseddiv');
    Route::post('/adminsendcertificate', [SeminarsController::class, 'sendCertificate'])->name('adminsendcertificate');
    Route::get('/generate-shistory-pdf', [PDFController::class, 'generateSeminarHistoryPdf'])->name('generate-shistory-pdf');
    // =======================
    //   Admin/Subscriptions
    // =======================
    Route::get('/subscriptions', [StaticPageController::class, 'subscriptionsIndex'])->name('adminsubscription');
    Route::post('/adminunsubscribe', [StaticPageController::class, 'adminUnsubscribe'])->name('adminunsubscribe');
    Route::get('/generate-subscription-pdf', [PDFController::class, 'generateSubscriptionPdf'])->name('generate-subscription-pdf');
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
    //   Admin/Reports
    // =======================
    Route::get('/adminreports', [ReportsController::class, 'index'])->name('adminreports');
    // =======================
    //     Admin/Logs
    // =======================
    Route::get('/logs', [StaticPageController::class, 'logsIndex'])->name('logs');
    Route::get('/generate-logs-pdf', [PDFController::class, 'generateLogsPdf'])->name('generate-logs-pdf');
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
    Route::get('/userreport', [ResidentController::class, 'userreport'])->name('userreport');
    Route::post('/userreportprocess', [ResidentController::class, 'userReportProcess'])->name('userreportprocess');
    Route::get('/userseminars', [ResidentController::class, 'userseminars'])->name('userseminars');
    Route::get('/userjoinseminar', [ResidentController::class, 'userJoinSeminar'])->name('userjoinseminar');
    Route::get('/userunregisterseminar', [ResidentController::class, 'userUnregisterSeminar'])->name('userunregisterseminar');
    Route::get('/userseminarreqcert', [ResidentController::class, 'userSeminarReqCert'])->name('userseminarreqcert');
    Route::get('/userprofile', [ResidentController::class, 'userprofile'])->name('userprofile');
    Route::post('/userupdateprofile', [ResidentController::class, 'userUpdateProfile'])->name('userupdateprofile');
    Route::post('/userupdatepassword', [ResidentController::class, 'userUpdatePassword'])->name('userupdatepassword');
    Route::get('/usernotif', [ResidentController::class, 'usernotif'])->name('usernotif');
    Route::get('/userremovenotif', [ResidentController::class, 'userRemoveNotif'])->name('userremovenotif');
});
