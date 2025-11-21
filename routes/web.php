<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;


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

Route::get('/', function () {
    return view('welcome');
});

// HOME & PUBLIC PAGES
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/home', [HomeController::class, 'home']);

// PRODUCTS - PUBLIC ACCESS (for users)
Route::get('/products', [ProdukController::class, 'index'])->middleware(['auth', 'verified'])->name('products.index');
Route::get('/produk', [ProdukController::class, 'index']); // alias for backward compatibility

// DASHBOARD - AUTHENTICATED USERS
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// PROFILE MANAGEMENT
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN ROUTES - PRODUCT MANAGEMENT (CRUD)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.admin');
    })->name('dashboard');
    
    // Product Management Routes
    Route::get('/products', [ProdukController::class, 'adminIndex'])->name('products.index');
    Route::get('/products/create', [ProdukController::class, 'create'])->name('products.create');
    Route::post('/products', [ProdukController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProdukController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProdukController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProdukController::class, 'destroy'])->name('products.destroy');
});

// ROLE-BASED DASHBOARD ACCESS
Route::get('/user', function () {
    return view('dashboard.user');
})->middleware(['auth', 'role:user'])->name('user.dashboard');

Route::get('/staff', function () {
    return view('dashboard.staff');
})->middleware(['auth', 'role:staff'])->name('staff.dashboard');

require __DIR__ . '/auth.php';  
