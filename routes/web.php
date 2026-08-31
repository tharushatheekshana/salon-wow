<?php

use App\Livewire\Admin\AppointmentDashboard;
use App\Livewire\Admin\ServiceManager;
use App\Livewire\BookingLookup;
use App\Livewire\BookingWizard;
use App\Livewire\CustomerAppointments;
use App\Livewire\Staff\StaffScheduleManager;
use Illuminate\Support\Facades\Route;

// Public Pages
Route::view('/', 'welcome')->name('home');
Route::get('/book', BookingWizard::class)->name('book');
Route::get('/track-booking', BookingLookup::class)->name('booking.lookup');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Smart Dashboard Router
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isStaff()) {
            return redirect()->route('staff.schedule');
        }

        return redirect()->route('customer.appointments');
    })->name('dashboard');

    // Customer Portal
    Route::get('/my-appointments', CustomerAppointments::class)->name('customer.appointments');

    // Admin Suite
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/appointments', AppointmentDashboard::class)->name('dashboard');
        Route::get('/services', ServiceManager::class)->name('services');
    });

    // Staff Suite
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/schedule', StaffScheduleManager::class)->name('schedule');
    });
});

require __DIR__.'/settings.php';
