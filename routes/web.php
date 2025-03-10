<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
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


Route::get('/', [DashboardController::class, 'index'])->middleware('auth');  

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
    });
});

require __DIR__.'/auth.php';
