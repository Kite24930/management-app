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
Route::post('/taskStatusEdit', [ApiController::class, 'taskStatusEdit'])->name('taskStatusEdit');
Route::post('/taskTitleEdit', [ApiController::class, 'taskTitleEdit'])->name('taskTitleEdit');
Route::post('/taskTypeEdit', [ApiController::class, 'taskTypeEdit'])->name('taskTypeEdit');
Route::post('/taskPriorityEdit', [ApiController::class, 'taskPriorityEdit'])->name('taskPriorityEdit');
Route::post('/taskMainMemberEdit', [ApiController::class, 'taskMainMemberEdit'])->name('taskMainMemberEdit');
Route::post('/taskStartDateEdit', [ApiController::class, 'taskStartDateEdit'])->name('taskStartDateEdit');
Route::post('/taskStartDateClear', [ApiController::class, 'taskStartDateClear'])->name('taskStartDateClear');
Route::post('/taskEndDateEdit', [ApiController::class, 'taskEndDateEdit'])->name('taskEndDateEdit');
Route::post('/taskEndDateClear', [ApiController::class, 'taskEndDateClear'])->name('taskEndDateClear');
Route::post('/taskTypeChange', [ApiController::class, 'taskTypeChange'])->name('taskTypeChange');
Route::post('/taskPriorityChange', [ApiController::class, 'taskPriorityChange'])->name('taskPriorityChange');
Route::post('/taskMainMemberChange', [ApiController::class, 'taskMainMemberChange'])->name('taskMainMemberChange');
Route::post('/taskStatusChange', [ApiController::class, 'taskStatusChange'])->name('taskStatusChange');
Route::post('/taskEdit', [ApiController::class, 'taskEdit'])->name('taskEdit');
Route::post('/taskMemberEdit', [ApiController::class, 'taskMemberEdit'])->name('taskMemberEdit');
Route::post('/taskOrderPost', [ApiController::class, 'taskOrderPost'])->name('taskOrderPost');
Route::post('/taskDescriptionEdit', [ApiController::class, 'taskDescriptionEdit'])->name('taskDescriptionEdit');
Route::post('/subTaskAdd', [ApiController::class, 'subTaskAdd'])->name('subTaskAdd');
Route::post('/subTaskCount', [ApiController::class, 'subTaskCount'])->name('subTaskCount');
Route::post('/modalCommentAdd', [ApiController::class, 'modalCommentAdd'])->name('modalCommentAdd');
Route::post('/modalCommentEdit', [ApiController::class, 'modalCommentEdit'])->name('modalCommentEdit');
Route::post('/modalCommentDelete', [ApiController::class, 'modalCommentDelete'])->name('modalCommentDelete');
Route::delete('/taskDelete/{id}', [ApiController::class, 'taskDelete'])->name('taskDelete');
Route::post('/admin/department', [ApiController::class, 'adminDepartmentPost'])->name('admin.department');
Route::post('/admin/user/create', [ApiController::class, 'adminUserCreate'])->name('admin.user.create');
Route::post('/admin/user/edit', [ApiController::class, 'adminUserEdit'])->name('admin.user.edit');
Route::post('/admin/user/delete', [ApiController::class, 'adminUserDelete'])->name('admin.user.delete');
Route::post('/notes/fetch/url', [ApiController::class, 'notesFetchUrl'])->name('notes.fetch.url');
Route::post('/notes/update', [ApiController::class, 'notesUpdate'])->name('notes.update');
