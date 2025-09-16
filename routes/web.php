<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketHistoryController;
use App\Http\Controllers\TicketReplyController;
use App\Models\Ticket;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest:web','preventBackHistory'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('/forgot/send', [AuthController::class, 'sendResetLink'])->name('forgot.sendResetLink');
});

Route::middleware(['auth:web','preventBackHistory'])->prefix('auth')->name('auth.')->group(function () {
    Route::get('/overview', [OverviewController::class, 'index'])->name('overview');
    // Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/list', [TicketController::class, 'list'])->name('tickets.list');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/show/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/reply/{ticket}', [TicketReplyController::class, 'store'])->name('tickets.reply');
    Route::get('/tickets/status/{ticket}', [TicketController::class, 'changeStatus'])->name('tickets.status');
    Route::post('/tickets/upload-chunk', [TicketController::class, 'uploadChunk'])->name('tickets.upload.chunk');
    
    //history
    Route::get('/tickets/history/{ticket}', [TicketHistoryController::class, 'show'])->name('tickets.history.show');

    // Ticket Reports 
    Route::get('/reports', [TicketController::class, 'report'])->name('report.index');
    Route::get('/reports/list', [TicketController::class, 'reportList'])->name('report.list');
    Route::get('/reports/generate', [TicketController::class, 'generateReport'])->name('report.generate.report'); 

    // account
    Route::get('/account/user', [AccountController::class, 'accountUser'])->name('account.user');
    Route::get('/account/user/create', [AccountController::class, 'accountCreateUser'])->name('account.user.create');
    Route::get('/account/user/{id}/edit', [AccountController::class, 'accountEditUser'])->name('account.user.edit');
    Route::post('/account/user/store', [AccountController::class, 'accountUserStore'])->name('account.user.store');
    Route::post('/account/user/update', [AccountController::class, 'accountUpdateUser'])->name('account.user.update');
    Route::get('/account/user/list', [AccountController::class, 'accountUserList'])->name('account.user.list');
    Route::get('/account/profile', [AccountController::class, 'accountProfile'])->name('account.profile');
    Route::post('/account/user/update-role', [AccountController::class, 'accountUpdateRole'])->name('account.user.update-role');
    Route::put('/profile/update', [AccountController::class, 'update'])->name('account.profile.update');

    // Notifications
    Route::prefix('notifications')->group(function() {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/read/{id}', [NotificationController::class, 'markRead'])->name('notifications.markRead');
        Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    }); 
   
    // Logout
    Route::get('/logout', [AuthController::class, 'signOut'])->name('logout');
});


