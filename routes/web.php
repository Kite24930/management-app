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

    Route::get('/reports', [MainController::class, 'reports'])->name('reports');
    Route::get('/reports/view/{id}', [MainController::class, 'reportsView'])->name('reports.view');
    Route::get('/reports/confirm/{id}', [MainController::class, 'reportsConfirm'])->name('reports.confirm');
    Route::get('/reports/add', [MainController::class, 'reportsAdd'])->name('reports.add');
    Route::post('/reports/add', [MainController::class, 'reportsAddPost'])->name('reports.add');
    Route::get('/reports/send/{id}', [MainController::class, 'reportsSend'])->name('reports.send');
    Route::post('/reports/send/{id}', [MainController::class, 'reportsSendPost'])->name('reports.send');
    Route::get('/reports/edit/{id}', [MainController::class, 'reportsEdit'])->name('reports.edit');
    Route::patch('/reports/edit/{id}', [MainController::class, 'reportsEditPost'])->name('reports.edit');
    Route::get('/reports/delete/{id}', [MainController::class, 'reportsDelete'])->name('reports.delete');
    Route::post('/reports/task/components', [MainController::class, 'reportsTaskComponents'])->name('reports.task.components');

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
