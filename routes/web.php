<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserRolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthFormController;
use App\Http\Controllers\RoleController;

// Public Routes
Route::get('/', fn () => view('welcome'));

Route::get('/login', [AuthFormController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthFormController::class, 'showRegisterForm'])->name('register');
Route::get('/logout', [AuthFormController::class, 'logout'])->name('logout');

Route::post('/web-login', [AuthFormController::class, 'login'])->name('web.login');
Route::post('/web-register', [AuthFormController::class, 'register'])->name('web.register');

// Protected Routes (Only for authenticated users)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Books
    Route::resource('books', BookController::class);

    // Lending
    Route::resource('lendings', LendingController::class)->only(['index', 'create', 'store']);
    Route::patch('lendings/{lending}/return', [LendingController::class, 'returnBook'])->name('lendings.return');

    // My Borrowed Books (for members)
    Route::get('my-books', [LendingController::class, 'myBorrowedBooks'])->name('lendings.mine');

    // Roles
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('users', UserController::class);

    // User Role Management
    Route::get('/user-role', [UserRolePermissionController::class, 'index'])->name('user-role.index');
    Route::get('/user-role/{user}/edit', [UserRolePermissionController::class, 'edit'])->name('user-role.edit');
    Route::put('/user-role/{user}', [UserRolePermissionController::class, 'update'])->name('user-role.update');

    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{id}/borrowings', [UserController::class, 'viewBorrowings'])->name('users.borrowings');
        Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    });
});



















