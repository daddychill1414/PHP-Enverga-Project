<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TuitionClearanceController;

Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/events/{id}/checkout', [TicketController::class, 'checkout'])->name('tickets.checkout');
Route::post('/events/{id}/checkout', [TicketController::class, 'processCheckout'])->name('tickets.processCheckout');
Route::get('/tickets/pass/{ticketNumber}', [TicketController::class, 'show'])->name('tickets.show');

Route::get('/clearance', [TuitionClearanceController::class, 'index'])->name('clearance.index');
Route::post('/clearance/check', [TuitionClearanceController::class, 'check'])->name('clearance.check');

// Institutional Pages (Authentic MSEUF Content)
Route::get('/about', [\App\Http\Controllers\PageController::class, 'about'])->name('pages.about');
Route::get('/internationalization', [\App\Http\Controllers\PageController::class, 'internationalization'])->name('pages.internationalization');
Route::get('/sustainability', [\App\Http\Controllers\PageController::class, 'sustainability'])->name('pages.sustainability');

Route::get('/api/verify-ticket', [TicketController::class, 'verify'])->name('tickets.verify');

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('admin.login');
    Route::get('/login-redirect', fn () => redirect()->route('admin.login'))->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard']);

        // QR Scanner
        Route::get('/scanner', [\App\Http\Controllers\AdminController::class, 'scanner'])->name('admin.scanner');
        Route::post('/scanner/verify', [\App\Http\Controllers\AdminController::class, 'verifyTicket'])->name('admin.scanner.verify');
        Route::post('/scanner/checkin', [\App\Http\Controllers\AdminController::class, 'checkIn'])->name('admin.scanner.checkin');

        // Payments
        Route::get('/payments', [\App\Http\Controllers\AdminController::class, 'payments'])->name('admin.payments');
        Route::patch('/payments/{id}/status', [\App\Http\Controllers\AdminController::class, 'updatePaymentStatus'])->name('admin.payments.updateStatus');

        // Tickets
        Route::get('/tickets', [\App\Http\Controllers\AdminController::class, 'tickets'])->name('admin.tickets');
        Route::patch('/tickets/{id}/cancel', [\App\Http\Controllers\AdminController::class, 'cancelTicket'])->name('admin.tickets.cancel');

        // Event Management (Create, List, Delete)
        Route::get('/events', [\App\Http\Controllers\AdminController::class, 'events'])->name('admin.events');
        Route::post('/events', [\App\Http\Controllers\AdminController::class, 'storeEvent'])->name('admin.events.store');
        Route::delete('/events/{id}', [\App\Http\Controllers\AdminController::class, 'deleteEvent'])->name('admin.events.delete');
    });
});
