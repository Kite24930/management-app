<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/tasks/{id?}', [MainController::class, 'tasks'])->name('tasks');

    Route::get('/notes', [MainController::class, 'notes'])->name('notes');
    Route::get('/notes/view/{id}', [MainController::class, 'notesView'])->name('notes.view');
    Route::get('/notes/edit/{id}', [MainController::class, 'notesEdit'])->name('notes.edit');
    Route::post('/notes/edit/{id}', [MainController::class, 'notesEditPost'])->name('notes.edit');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin', [MainController::class, 'admin'])->name('admin');
        Route::get('/admin/department', [MainController::class, 'adminDepartment'])->name('admin.department');
        Route::post('/admin/department', [MainController::class, 'adminDepartmentPost'])->name('admin.department');
        Route::get('/admin/users/list', [MainController::class, 'adminUsersList'])->name('admin.users.list');
    });

    Route::group(['middleware' => ['role:manager']], function () {
        Route::get('/manager', [MainController::class, 'manager'])->name('manager');
    });

    Route::get('/profile/first-login', [ProfileController::class, 'firstLogin'])->name('profile.first-login');
    Route::put('/profile/first-login', [ProfileController::class, 'firstLoginUpdate'])->name('profile.first-login-update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
