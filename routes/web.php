<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CertificateDetailController;
use App\Http\Controllers\CertificateTypeController;
use App\Http\Controllers\ComplaintDetailController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\OfficialTitleController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProjectDetailController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('landing_page');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    return view('admin.adminpage');
})->middleware(['auth', 'admin']);

Route::get('/staff', function () {
    return view('staff.staffpage');
})->middleware(['auth', 'staff']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('landing_page');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [DashboardController::class, 'AdminStaff'])->name('Home');

    // ✅ ADMIN ONLY
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('officials', OfficialController::class);
        Route::resource('certificate_types', CertificateTypeController::class);
        Route::resource('fines', FineController::class);
        Route::resource('payment_methods', PaymentMethodController::class);
        Route::resource('project_types', ProjectTypeController::class);
        Route::resource('statuses', StatusController::class);
        Route::resource('official_titles', OfficialTitleController::class);
        Route::resource('transaction_types', TransactionTypeController::class);
        Route::resource('complaint_types', ComplaintTypeController::class);

    });

    // ✅ SHARED (NO role middleware)
    Route::resource('residents', ResidentController::class);
    Route::resource('certificate_details', CertificateDetailController::class);
    Route::resource('complaint_details', ComplaintDetailController::class);
    Route::resource('project_details', ProjectDetailController::class);
    Route::resource('transaction_details', TransactionDetailController::class);
    Route::resource('violations', ViolationController::class);

});
