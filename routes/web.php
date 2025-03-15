<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomPhotoController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\RoomPolicyController;
use App\Http\Controllers\RoomPriceController;
use App\Http\Controllers\RoomAvailabilityController;

use Illuminate\Support\Facades\Route; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [DashboardController::class, 'index']);  

Route::middleware('auth')->group(function () {
    Route::prefix('management')->group(function () {  
        Route::get('/', [DashboardController::class, 'dashboard']);
        Route::prefix('user')->group(function () { 
            Route::get('/', [UserController::class, 'index']); 
            Route::get('/edit/{id}', [UserController::class, 'edit']); 
            Route::put('/update/{user}', [UserController::class, 'update'])->name('users.update'); 
            Route::post('/store', [UserController::class, 'store']); 
            Route::get('/delete/{id}', [UserController::class, 'destroy']); 
        });
        Route::prefix('role')->group(function () { 
            Route::get('/', [RoleController::class, 'index']); 
            Route::get('/edit/{id}', [RoleController::class, 'edit']); 
            Route::put('/update/{role}', [RoleController::class, 'update'])->name('roles.update'); 
            Route::post('/store', [RoleController::class, 'store']); 
            Route::get('/delete/{id}', [RoleController::class, 'destroy']); 
        });
        Route::prefix('permission')->group(function () { 
            Route::get('/', [PermissionController::class, 'index']); 
            Route::get('/edit/{id}', [PermissionController::class, 'edit']); 
            Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('permissions.update'); 
            Route::post('/store', [PermissionController::class, 'store']); 
            Route::get('/delete/{id}', [PermissionController::class, 'destroy']); 
        });
        Route::prefix('config')->group(function () { 
            Route::prefix('branches')->group(function () { 
                Route::get('/', [BranchController::class, 'index']); 
                Route::get('/detail/{id}', [BranchController::class, 'show']); 
                Route::get('/edit/{id}', [BranchController::class, 'edit']); 
                Route::post('/update', [BranchController::class, 'update']); 
                Route::post('/store', [BranchController::class, 'store']); 
                Route::get('/delete/{id}', [BranchController::class, 'destroy']); 
            });
        });

        //Amenities
        Route::resource('amenities', AmenityController::class)->except(['show']);
        Route::get('amenities/datatable', [AmenityController::class, 'datatable'])
            ->name('amenities.datatable');

        //Room Policy
        Route::resource('room-policies', RoomPolicyController::class)->except(['show']);
        Route::get('room-policies/datatable', [RoomPolicyController::class, 'datatable'])
        ->name('room-policies.datatable');

            // Room Management
        Route::resource('rooms', RoomController::class)->except(['show']);
        
        // Room Photos
        Route::post('rooms/{room}/photos', [RoomPhotoController::class, 'store'])
            ->name('rooms.photos.store');
        Route::put('photos/{photo}', [RoomPhotoController::class, 'update'])
            ->name('rooms.photos.update');
        Route::delete('photos/{photo}', [RoomPhotoController::class, 'destroy'])
            ->name('rooms.photos.destroy');

        // Pricing Management
        Route::prefix('rooms/{room}')->group(function() {
            Route::get('prices', [RoomPriceController::class, 'index'])->name('prices.index'); 
            Route::get('prices/events', [RoomPriceController::class, 'getCalendarEvents'])->name('prices.events');
            Route::post('prices/bulk-update', [RoomPriceController::class, 'bulkUpdate'])->name('prices.bulk-update');
            Route::put('prices/update-single', [RoomPriceController::class, 'updateSingle'])->name('prices.update-single');
            Route::delete('prices/bulk-delete', [RoomPriceController::class, 'bulkDelete'])->name('prices.bulk-delete');
            Route::delete('prices/delete-single', [RoomPriceController::class, 'deleteSingle'])->name('prices.delete-single');
            Route::get('prices/check-existing', [RoomPriceController::class, 'checkExisting'])->name('prices.check-existing');
             
        });
        Route::get('/rooms/dynamic-pricing', [RoomPriceController::class, 'dynamicPricing'])->name('prices.dynamic-pricing');
        Route::get('/rooms/weekly', [RoomPriceController::class, 'weekly'])->name('prices.weekly');
        Route::get('/rooms/calendar', [RoomPriceController::class, 'calendar'])->name('prices.calendar');


        // Availability Management
        Route::get('rooms/{room}/availability', [RoomAvailabilityController::class, 'index'])
            ->name('availability.index');
        Route::post('rooms/{room}/availability/bulk', [RoomAvailabilityController::class, 'bulkUpdate'])
            ->name('availability.bulk-update');
        Route::delete('availability/{availability}', [RoomAvailabilityController::class, 'destroy'])
            ->name('availability.destroy');
        });

        Route::post('rooms/datatable', [RoomController::class, 'datatable'])
        ->name('rooms.datatable');
 
});
 
// Frontend Routes
Route::controller(RoomController::class)->group(function () {
    Route::get('/rooms', 'index')->name('frontend.rooms.index');
    Route::get('/rooms/{room}', 'show')->name('frontend.rooms.show');
});

require __DIR__.'/auth.php';
