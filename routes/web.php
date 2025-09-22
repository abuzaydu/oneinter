<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarCategoryController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboardController;


Route::get('/', [ClientController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');

    // Car Categories Routes
    Route::resource('admin/car-categories', CarCategoryController::class)->names([
        'index' => 'admin.car-categories.index',
        'create' => 'admin.car-categories.create',
        'store' => 'admin.car-categories.store',
        'edit' => 'admin.car-categories.edit',
        'update' => 'admin.car-categories.update',
        'destroy' => 'admin.car-categories.destroy',
    ])->middleware('permission:view_cars');
    Route::patch('admin/car-categories/{carCategory}/toggle-favorite', [CarCategoryController::class, 'toggleFavorite'])->name('admin.car-categories.toggle-favorite')->middleware('permission:edit_cars');

    // Cars Routes
    Route::resource('admin/cars', CarController::class)->except(['show'])->names([
        'index' => 'admin.cars.index',
        'create' => 'admin.cars.create',
        'store' => 'admin.cars.store',
        'edit' => 'admin.cars.edit',
        'update' => 'admin.cars.update',
        'destroy' => 'admin.cars.destroy',
    ])->middleware('permission:view_cars');
    
    // Car Export Routes (Admin Only)
    Route::get('admin/cars/export/excel', [CarController::class, 'exportExcel'])->name('admin.cars.export-excel');
    Route::get('admin/cars/export/pdf', [CarController::class, 'exportPdf'])->name('admin.cars.export-pdf');

    // Bookings Routes
    Route::resource('admin/bookings', BookingController::class)->names([
        'index' => 'admin.bookings.index',
        'create' => 'admin.bookings.create',
        'store' => 'admin.bookings.store',
        'show' => 'admin.bookings.show',
        'update' => 'admin.bookings.update',
        'destroy' => 'admin.bookings.destroy',
    ])->middleware('permission:view_bookings');
    Route::patch('admin/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.update-status')->middleware('permission:edit_bookings');
    Route::get('admin/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('admin.bookings.checkout')->middleware('permission:edit_bookings');
    Route::post('admin/bookings/{booking}/checkout', [BookingController::class, 'processCheckout'])->name('admin.bookings.process-checkout')->middleware('permission:edit_bookings');
    Route::post('admin/bookings/{booking}/return', [BookingController::class, 'returnCar'])->name('admin.bookings.return-car')->middleware('permission:edit_bookings');
    Route::post('admin/bookings/{booking}/return-only', [BookingController::class, 'returnCarOnly'])->name('admin.bookings.return-car-only')->middleware('permission:edit_bookings');
    Route::get('admin/bookings/{booking}/extend', [BookingController::class, 'extendTrip'])->name('admin.bookings.extend-trip')->middleware('permission:edit_bookings');
    Route::post('admin/bookings/{booking}/extend', [BookingController::class, 'processExtendTrip'])->name('admin.bookings.process-extend-trip')->middleware('permission:edit_bookings');
    
    // Export Routes (Admin Only)
    Route::get('admin/bookings/export/excel', [BookingController::class, 'exportExcel'])->name('admin.bookings.export-excel');
    Route::get('admin/bookings/export/pdf', [BookingController::class, 'exportPdf'])->name('admin.bookings.export-pdf');

    // Drivers Routes
    Route::resource('admin/drivers', DriverController::class)->names([
        'index' => 'admin.drivers.index',
        'create' => 'admin.drivers.create',
        'store' => 'admin.drivers.store',
        'show' => 'admin.drivers.show',
        'edit' => 'admin.drivers.edit',
        'update' => 'admin.drivers.update',
        'destroy' => 'admin.drivers.destroy',
    ])->middleware('permission:view_drivers');

    // Users Routes
    Route::resource('admin/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ])->middleware('permission:view_users');
    Route::post('admin/users/{user}/send-password-reset', [UserController::class, 'sendPasswordReset'])->name('admin.users.send-password-reset')->middleware('permission:edit_users');

    Route::resource('admin/roles', RoleController::class)->names([
        'index' => 'admin.roles.index',
        'create' => 'admin.roles.create',
        'store' => 'admin.roles.store',
        'show' => 'admin.roles.show',
        'edit' => 'admin.roles.edit',
        'update' => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
    ])->middleware('permission:view_roles');


    


    Route::post('/admin/notifications/mark-all-read', function () {
        $user = auth()->user();
        if ($user) {
            $user->unreadNotifications()->where('type', 'App\\Notifications\\NewBookingNotification')->update(['read_at' => now()]);
        }
        return back();
    })->name('admin.notifications.markAllRead')->middleware('auth');
});

// Client Routes
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('home');
    Route::get('/about', [ClientController::class, 'about'])->name('about');
    Route::get('/cars', [ClientController::class, 'cars'])->name('cars');
    Route::get('/contact', [ClientController::class, 'contact'])->name('contact');
    Route::post('/contact', [ClientController::class, 'submitContact'])->name('submit-contact');
    Route::get('/quick-booking', [ClientController::class, 'quickBooking'])->name('quick-booking');
    Route::post('/quick-booking', [ClientController::class, 'storeBooking'])->name('store-booking');
    Route::get('/get-available-colors', [ClientController::class, 'getAvailableColors'])->name('get-available-colors');
});

require __DIR__.'/auth.php';
