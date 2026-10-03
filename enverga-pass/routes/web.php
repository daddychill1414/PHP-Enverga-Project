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

Route::get('/api/verify-ticket', [TicketController::class, 'verify'])->name('tickets.verify');
