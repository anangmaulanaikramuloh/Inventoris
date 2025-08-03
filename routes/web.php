<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;

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
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('auth.auth');
})->name('welcome');

// Custom Auth Routes for displaying the single page
Route::get('login', function() { return view('auth.auth'); })->name('login');
Route::get('register', function() { return view('auth.auth'); })->name('register');

// Manually define POST routes for authentication logic
Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    // Home Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Items
    Route::resource('items', ItemController::class);

    // Stock Transaction Routes
    Route::post('items/{item}/stock-in', [StockTransactionController::class, 'stockIn'])->name('items.stock.in');
    Route::post('items/{item}/stock-out', [StockTransactionController::class, 'stockOut'])->name('items.stock.out');

    // Report Routes
    Route::get('reports/current-stock', [ReportController::class, 'currentStock'])->name('reports.current_stock');
    Route::get('reports/stock-movement', [ReportController::class, 'stockMovement'])->name('reports.stock_movement');

    // User Management Routes
    Route::resource('users', UserController::class)->middleware(['can:manage users']);

    // Profile Routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // DEBUG ROUTE: Check User Permissions
    Route::get('/debug-permissions', function () {
        if (Auth::check()) {
            $user = Auth::user();
            $roles = $user->getRoleNames();
            $permissions = $user->getAllPermissions()->pluck('name');
            return response()->json([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'roles' => $roles,
                'permissions' => $permissions,
            ]);
        }
        return response()->json(['message' => 'User not authenticated.'], 401);
    })->name('debug.permissions');
});

// Storage route for serving uploaded files (outside auth middleware)
Route::get('/storage/{path}', function ($path) {
    // Prevent path traversal attacks
    $path = str_replace(['../', '.\\', '..\\'], '', $path);
    $file = storage_path('app/public/' . $path);
    
    if (file_exists($file) && is_file($file)) {
        return response()->file($file);
    }
    abort(404);
})->where('path', '.*')->name('storage.local');
