<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/addTask', [ApiController::class, 'addTask'])->name('addTask');
Route::post('/addTask', [ApiController::class, 'addTaskPost'])->name('addTask');
Route::post('/taskTitleEdit', [ApiController::class, 'taskTitleEdit'])->name('taskTitleEdit');
Route::post('/taskTypeEdit', [ApiController::class, 'taskTypeEdit'])->name('taskTypeEdit');
Route::post('/taskPriorityEdit', [ApiController::class, 'taskPriorityEdit'])->name('taskPriorityEdit');
Route::post('/taskMainMemberEdit', [ApiController::class, 'taskMainMemberEdit'])->name('taskMainMemberEdit');
Route::post('/taskStartDateEdit', [ApiController::class, 'taskStartDateEdit'])->name('taskStartDateEdit');
Route::post('/taskEndDateEdit', [ApiController::class, 'taskEndDateEdit'])->name('taskEndDateEdit');
Route::post('/taskTypeChange', [ApiController::class, 'taskTypeChange'])->name('taskTypeChange');
Route::post('/taskPriorityChange', [ApiController::class, 'taskPriorityChange'])->name('taskPriorityChange');
Route::post('/taskMainMemberChange', [ApiController::class, 'taskMainMemberChange'])->name('taskMainMemberChange');
Route::post('/taskEdit', [ApiController::class, 'taskEdit'])->name('taskEdit');
Route::post('/taskMemberEdit', [ApiController::class, 'taskMemberEdit'])->name('taskMemberEdit');
Route::post('/taskOrderPost', [ApiController::class, 'taskOrderPost'])->name('taskOrderPost');
