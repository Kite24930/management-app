<?php

namespace App\Http\Controllers;

use App\Models\CancelList;
use App\Models\CancelTask;
use App\Models\Comment;
use App\Models\CommentList;
use App\Models\CompletedList;
use App\Models\CompletedTask;
use App\Models\Department;
use App\Models\Link;
use App\Models\MemberList;
use App\Models\Note;
use App\Models\OtherList;
use App\Models\OtherTask;
use App\Models\PendingList;
use App\Models\PendingTask;
use App\Models\ProgressList;
use App\Models\ProgressTask;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\TaskLog;
use App\Models\TaskMember;
use App\Models\TaskType;
use App\Models\ToDoList;
use App\Models\ToDoTask;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function addTask(Request $request) {
        $users = User::all();
        $target = Task::max('id');
        $status = $request->status;
        if ($target == null) {
            $target = 1;
        } else {
            $target++;
        }
        return response()->json([
            'view' => view('api.addTask', compact('users', 'target', 'status'))->render(),
            'target' => $target,
        ]);
    }

    public function addTaskPost(Request $request) {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'priority' => 'required',
            'parent_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $addTask = Task::create([
                'title' => $request->title,
                'parent_id' => $request->parent_id,
                'type' => $request->type,
                'priority' => $request->priority,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'created_by' => $request->login_user,
                'status' => $request->status,
            ]);
            if ($request->main_person_id) {
                TaskMember::create([
                    'task_id' => $addTask->id,
                    'member_id' => $request->main_person_id,
                    'is_main_person' => 1,
                ]);
            }
            $users = User::all();
            $departments = Department::all();
            $task_types = TaskType::all();
            $members = TaskMember::all();
            $comments = Comment::all();
            $log = TaskLog::all();
            $task_id = $addTask->id;
            switch ($request->status) {
                case 0:
                    $todo = ToDoTask::create([
                        'task_id' => $task_id,
                    ]);
                    $task = ToDoList::where('task_id', $task_id)->first();
                    break;
                case 1:
                    $progress = ProgressTask::create([
                        'task_id' => $task_id,
                    ]);
                    $task = ProgressList::where('task_id', $task_id)->first();
                    break;
                case 2:
                    $pending = PendingTask::create([
                        'task_id' => $task_id,
                    ]);
                    $task = PendingList::where('task_id', $task_id)->first();
                    break;
                case 3:
                    $completed = CompletedTask::create([
                        'task_id' => $task_id,
                    ]);
                    $task = CompletedList::where('task_id', $task_id)->first();
                    break;
                case 4:
                    $other = OtherTask::create([
                        'task_id' => $task_id,
                    ]);
                    $task = OtherList::where('task_id', $task_id)->first();
                    break;
                case 5:
                    $cancel = CancelTask::create([
                        'task_id' => $task_id,
                    ]);
                    $task = CancelList::where('task_id', $task_id)->first();
                    break;
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Task added successfully',
                'target' => $task_id,
                'view' => view('components.self.task-item', compact('task', 'users', 'departments', 'task_types', 'members', 'comments', 'log'))->render(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add task'. $e->getMessage(),
            ]);
        }
    }

    public function taskStatusEdit(Request $request) {
        $request->validate([
            'status' => 'required',
            'task_id' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $task = Task::find($request->task_id)->update([
                'status' => $request->status,
            ]);
            $task_id = $request->task_id;
            ToDoTask::where('task_id', $request->task_id)->delete();
            ProgressTask::where('task_id', $request->task_id)->delete();
            PendingTask::where('task_id', $request->task_id)->delete();
            CompletedTask::where('task_id', $request->task_id)->delete();
            OtherTask::where('task_id', $request->task_id)->delete();
            CancelTask::where('task_id', $request->task_id)->delete();
            switch ($request->status) {
                case 0:
                    $todo = ToDoTask::create([
                        'task_id' => $task_id,
                    ]);
                    $view_name = 'components.icons.todo';
                    break;
                case 1:
                    $progress = ProgressTask::create([
                        'task_id' => $task_id,
                    ]);
                    $view_name = 'components.icons.progress';
                    break;
                case 2:
                    $pending = PendingTask::create([
                        'task_id' => $task_id,
                    ]);
                    $view_name = 'components.icons.pending';
                    break;
                case 3:
                    $completed = CompletedTask::create([
                        'task_id' => $task_id,
                    ]);
                    $view_name = 'components.icons.completed';
                    break;
                case 4:
                    $other = OtherTask::create([
                        'task_id' => $task_id,
                    ]);
                    $view_name = 'components.icons.other';
                    break;
                case 5:
                    $cancel = CancelTask::create([
                        'task_id' => $task_id,
                    ]);
                    $view_name = 'components.icons.cancel';
                    break;
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Task status updated successfully',
                'view' => view($view_name)->render(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task status'. $e->getMessage(),
            ]);
        }
    }

    public function taskTitleEdit(Request $request) {
        $request->validate([
            'title' => 'required',
            'task_id' => 'required',
        ]);
        try {
            $task = Task::find($request->task_id)->update(
                ['title' => $request->title]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Task title updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task title'. $e->getMessage(),
            ]);
        }
    }

    public function taskTypeEdit(Request $request) {
        $request->validate([
            'type' => 'required',
            'task_id' => 'required',
        ]);
        try {
            $task = Task::find($request->task_id)->update(
                ['type' => $request->type]
            );
            switch ($request->type) {
                case 1:
                    $view = 'components.icons.internal-project';
                    break;
                case 2:
                    $view = 'components.icons.orders-receive';
                    break;
                case 3:
                    $view = 'components.icons.head-office-order';
                    break;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Task type updated successfully',
                'view' => view($view)->render(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task type:'. $e->getMessage(),
            ]);
        }
    }

    public function taskPriorityEdit(Request $request) {
        $request->validate([
            'priority' => 'required',
            'task_id' => 'required',
        ]);
        try {
            $task = Task::find($request->task_id)->update(
                ['priority' => $request->priority]
            );
            switch ($request->priority) {
                case 1:
                    $view = 'components.icons.highest';
                    break;
                case 2:
                    $view = 'components.icons.high';
                    break;
                case 3:
                    $view = 'components.icons.middle';
                    break;
                case 4:
                    $view = 'components.icons.low';
                    break;
                case 5:
                    $view = 'components.icons.lowest';
                    break;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Task priority updated successfully',
                'view' => view($view)->render(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task priority:'. $e->getMessage(),
            ]);
        }
    }

    public function taskMainMemberEdit(Request $request) {
        $request->validate([
            'member_id' => 'required',
            'task_id' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $oldMainMember = TaskMember::where('task_id', $request->task_id)->where('is_main_person', 1)->first();
            if ($oldMainMember) {
                $oldMainMember->update([
                    'is_main_person' => 0,
                ]);
            }
            $newMainMember = TaskMember::updateOrCreate(
                ['task_id' => $request->task_id, 'member_id' => $request->member_id],
                ['is_main_person' => 1]
            );
            $user = User::find($request->member_id);
            $members = MemberList::where('task_id', $request->task_id)->whereNot('is_main_person', 1)->get();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Task main member updated successfully',
                'user' => $user,
                'members' => $members,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task main member:'. $e->getMessage(),
            ]);
        }
    }

    public function taskStartDateEdit(Request $request) {
        $request->validate([
            'start_date' => 'required',
            'task_id' => 'required',
        ]);
        try {
            $task = Task::find($request->task_id)->update(
                ['start_date' => $request->start_date]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Task start date updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task start date:'. $e->getMessage(),
            ]);
        }
    }

    public function taskStartDateClear(Request $request) {
        $request->validate([
            'task_id' => 'required',
        ]);
        try {
            $task = Task::find($request->task_id)->update(
                ['start_date' => null]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Task start date cleared successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear task start date:'. $e->getMessage(),
            ]);
        }
    }

    public function taskEndDateEdit(Request $request) {
        $request->validate([
            'end_date' => 'required',
            'task_id' => 'required',
        ]);
        try {
            $task = Task::find($request->task_id)->update(
                ['end_date' => $request->end_date]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Task end date updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task end date:'. $e->getMessage(),
            ]);
        }
    }

    public function taskEndDateClear(Request $request) {
        $request->validate([
            'task_id' => 'required',
        ]);
        try {
            $task = Task::find($request->task_id)->update(
                ['end_date' => null]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Task end date cleared successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear task end date:'. $e->getMessage(),
            ]);
        }
    }

    public function taskTypeChange(Request $request) {
        try {
            switch ($request->type) {
                case 1:
                    $view = 'components.icons.internal-project';
                    break;
                case 2:
                    $view = 'components.icons.orders-receive';
                    break;
                case 3:
                    $view = 'components.icons.head-office-order';
                    break;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Task type updated successfully',
                'view' => view($view)->render(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task type:'. $e->getMessage(),
            ]);
        }
    }

    public function taskPriorityChange(Request $request) {
        try {
            switch ($request->priority) {
                case 1:
                    $view = 'components.icons.highest';
                    break;
                case 2:
                    $view = 'components.icons.high';
                    break;
                case 3:
                    $view = 'components.icons.middle';
                    break;
                case 4:
                    $view = 'components.icons.low';
                    break;
                case 5:
                    $view = 'components.icons.lowest';
                    break;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Task priority updated successfully',
                'view' => view($view)->render(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task priority:'. $e->getMessage(),
            ]);
        }
    }

    public function taskMainMemberChange(Request $request) {
        try {
            $user = User::find($request->member_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Task main member updated successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task main member:'. $e->getMessage(),
            ]);
        }
    }

    public function taskStatusChange(Request $request) {
        try {
            switch ($request->status) {
                case 0:
                    $view = 'components.icons.todo';
                    break;
                case 1:
                    $view = 'components.icons.progress';
                    break;
                case 2:
                    $view = 'components.icons.pending';
                    break;
                case 3:
                    $view = 'components.icons.completed';
                    break;
                case 4:
                    $view = 'components.icons.other';
                    break;
                case 5:
                    $view = 'components.icons.cancel';
                    break;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Task status updated successfully',
                'view' => view($view)->render(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task status:'. $e->getMessage(),
            ]);
        }
    }

    public function taskEdit(Request $request) {
        try {
            $users = User::all();
            $departments = Department::all();
            $task_types = TaskType::all();
            $task = TaskList::find($request->task_id);
            $targetTask = TaskList::find($request->task_id);
            $parent_tasks = [];
            while ($targetTask->parent_id !== 0) {
                $parent_tasks[] = TaskList::find($targetTask->parent_id);
                $targetTask = TaskList::find($targetTask->parent_id);
            }
            $member_list = TaskMember::where('task_id', $request->task_id)->pluck('member_id')->toArray();
            $members = MemberList::where('task_id', $request->task_id)->get();
            $sub_tasks['all'] = Task::where('parent_id', $request->task_id)->count();
            $sub_tasks['todo'] = Task::where('parent_id', $request->task_id)->where('status', 0)->count();
            $sub_tasks['progress'] = Task::where('parent_id', $request->task_id)->where('status', 1)->count();
            $sub_tasks['pending'] = Task::where('parent_id', $request->task_id)->where('status', 2)->count();
            $sub_tasks['completed'] = Task::where('parent_id', $request->task_id)->where('status', 3)->count();
            $sub_tasks['other'] = Task::where('parent_id', $request->task_id)->where('status', 4)->count();
            $sub_tasks['cancel'] = Task::where('parent_id', $request->task_id)->where('status', 5)->count();
            $sub_tasks['tasks'] = TaskList::where('parent_id', $request->task_id)->get();
            $comments = CommentList::where('task_id', $request->task_id)->orderBy('created_at')->get();
            $active_user = User::find($request->login_user);
            return response()->json([
                'status' => 'success',
                'message' => 'Task updated successfully',
                'view' => view('api.modal', compact('task', 'parent_tasks', 'member_list', 'members', 'sub_tasks', 'comments', 'active_user'))->render(),
                'request' => $request->all(),
                'values' => compact('task', 'parent_tasks', 'member_list', 'members', 'sub_tasks', 'comments', 'active_user'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task:'. $e->getMessage(),
            ]);
        }
    }

    public function subTaskAdd(Request $request) {
        try {
            $parentTask = Task::find($request->parent_id);
            $addTask = Task::create([
                'title' => $request->title,
                'parent_id' => $request->parent_id,
                'type' => $parentTask->type,
                'priority' => $request->priority,
                'created_by' => $request->login_user,
                'status' => $request->status,
            ]);
            TaskMember::create([
                'task_id' => $addTask->id,
                'member_id' => $request->main_person_id,
                'is_main_person' => 1,
            ]);
            switch ($request->status) {
                case 0:
                    $todo = ToDoTask::create([
                        'task_id' => $addTask->id,
                    ]);
                    break;
                case 1:
                    $progress = ProgressTask::create([
                        'task_id' => $addTask->id,
                    ]);
                    break;
                case 2:
                    $pending = PendingTask::create([
                        'task_id' => $addTask->id,
                    ]);
                    break;
                case 3:
                    $completed = CompletedTask::create([
                        'task_id' => $addTask->id,
                    ]);
                    break;
                case 4:
                    $other = OtherTask::create([
                        'task_id' => $addTask->id,
                    ]);
                    break;
                case 5:
                    $cancel = CancelTask::create([
                        'task_id' => $addTask->id,
                    ]);
                    break;
            }
            $users = User::all();
            $subTasks = TaskList::where('parent_id', $request->parent_id)->get();
            foreach ($subTasks as $task) {
                $view[] = view('components.self.modal-subtask', compact('task', 'users'))->render();
            }
            $view[] = view('components.self.modal-subtask-add', compact('users'))->render();
            return response()->json([
                'status' => 'success',
                'message' => 'Sub task added successfully',
                'views' => $view,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed add sub task:'. $e->getMessage(),
            ]);
        }
    }

    public function taskMemberEdit(Request $request) {
        try {
            TaskMember::where('task_id', $request->task_id)->whereNot('is_main_person', 1)->delete();
            foreach ($request->members as $member_id) {
                TaskMember::create([
                    'task_id' => $request->task_id,
                    'member_id' => $member_id,
                    'is_main_person' => 0,
                ]);
            }
            $members = MemberList::where('task_id', $request->task_id)->whereIn('id', $request->members)->whereNot('is_main_person', 1)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Task member updated successfully',
                'members' => $members,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed update task member:'. $e->getMessage(),
            ]);
        }
    }

    public function taskOrderPost(Request $request) {
        try {
            DB::beginTransaction();
            ToDoTask::whereIn('task_id', $request->all)->delete();
            ProgressTask::whereIn('task_id', $request->all)->delete();
            PendingTask::whereIn('task_id', $request->all)->delete();
            CompletedTask::whereIn('task_id', $request->all)->delete();
            OtherTask::whereIn('task_id', $request->all)->delete();
            CancelTask::whereIn('task_id', $request->all)->delete();
            $tables = ['to_do_tasks', 'progress_tasks', 'pending_tasks', 'completed_tasks', 'other_tasks', 'cancel_tasks'];
            foreach ($tables as $table) {
                $maxId = DB::table($table)->max('id');
                $maxId = is_numeric($maxId) ? $maxId + 1 : 1; // nullの場合は1を設定
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = $maxId");
            }
            DB::beginTransaction(); // ALTER TABLEによって、トランザクションが自動的にコミットされてしまうので、再度トランザクションを開始する
            foreach ($request->todo as $task) {
                ToDoTask::create([
                    'task_id' => $task,
                ]);
                Task::find($task)->update([
                    'status' => 0,
                ]);
            }
            foreach ($request->progress as $task) {
                ProgressTask::create([
                    'task_id' => $task,
                ]);
                Task::find($task)->update([
                    'status' => 1,
                ]);
            }
            foreach ($request->pending as $task) {
                PendingTask::create([
                    'task_id' => $task,
                ]);
                Task::find($task)->update([
                    'status' => 2,
                ]);
            }
            foreach ($request->completed as $task) {
                CompletedTask::create([
                    'task_id' => $task,
                ]);
                Task::find($task)->update([
                    'status' => 3,
                ]);
            }
            foreach ($request->other as $task) {
                OtherTask::create([
                    'task_id' => $task,
                ]);
                Task::find($task)->update([
                    'status' => 4,
                ]);
            }
            foreach ($request->cancel as $task) {
                CancelTask::create([
                    'task_id' => $task,
                ]);
                Task::find($task)->update([
                    'status' => 5,
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Task order updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed update task order:'. $e->getMessage(),
            ]);
        }
    }

    public function taskDescriptionEdit(Request $request) {
        try {
            $task = Task::find($request->task_id)->update(
                ['description' => $request->description]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Task description updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed update task description:'. $e->getMessage(),
            ]);
        }
    }

    public function subTaskCount(Request $request) {
        try {
            $task_id = $request->task_id;
            $sub_tasks['all'] = Task::where('parent_id', $task_id)->count();
            $sub_tasks['todo'] = Task::where('parent_id', $task_id)->where('status', 0)->count();
            $sub_tasks['progress'] = Task::where('parent_id', $task_id)->where('status', 1)->count();
            $sub_tasks['pending'] = Task::where('parent_id', $task_id)->where('status', 2)->count();
            $sub_tasks['completed'] = Task::where('parent_id', $task_id)->where('status', 3)->count();
            $sub_tasks['other'] = Task::where('parent_id', $task_id)->where('status', 4)->count();
            $sub_tasks['cancel'] = Task::where('parent_id', $task_id)->where('status', 5)->count();
            return response()->json([
                'status' => 'success',
                'message' => 'Sub task count updated successfully',
                'sub_tasks' => $sub_tasks,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed update sub task count:'. $e->getMessage(),
            ]);
        }
    }

    public function modalCommentAdd(Request $request) {
        try {
            $comment = Comment::create([
                'task_id' => $request->task_id,
                'user_id' => $request->login_user,
                'comment' => $request->comment,
            ]);
            $comments = CommentList::where('task_id', $request->task_id)->get();
            $user = User::find($request->login_user);
            foreach ($comments as $comment) {
                $view[] = view('components.self.modal-comment', compact('comment', 'user'))->render();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Comment added successfully',
                'views' => $view,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed add comment:'. $e->getMessage(),
            ]);
        }
    }

    public function modalCommentEdit(Request $request) {
        try {
            $comment = Comment::find($request->comment_id)->update([
                'comment' => $request->comment,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Comment edited successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed edit comment:'. $e->getMessage(),
            ]);
        }
    }

    public function modalCommentDelete(Request $request) {
        try {
            $comment = Comment::find($request->comment_id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Comment deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed delete comment:'. $e->getMessage(),
            ]);
        }
    }

    public function taskDelete($id) {
        try {
            $task = Task::find($id);
            $task->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed delete task:'. $e->getMessage(),
            ]);
        }
    }

    public function adminDepartmentPost(Request $request) {
        try {
            $department = Department::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'parent_department' => $request->parent_department,
                ]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Department added successfully',
                'department' => $department,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed add department:'. $e->getMessage(),
            ]);
        }
    }

    public function adminUserCreate(Request $request) {
        try {
            $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'belong_to' => $request->belong_to,
                    'password' => bcrypt('20220701'),
                ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User added successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed add user:'. $e->getMessage(),
            ]);
        }
    }

    public function adminUserEdit(Request $request) {
        try {
            $user = User::find($request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'belong_to' => $request->belong_to,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User edited successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed edit user:'. $e->getMessage(),
            ]);
        }
    }

    public function adminUserDelete(Request $request) {
        try {
            $user = User::find($request->id);
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed delete user:'. $e->getMessage(),
            ]);
        }
    }

    public function notesSetUrl(Request $request) {
        try {
            $links = Link::whereIn('url', $request->url)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'URL set successfully',
                'note' => $links,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed set URL:'. $e->getMessage(),
            ]);
        }
    }

    public function notesFetchUrl(Request $request) {
        foreach ($request->url as $url) {
            try {
                $client = new Client();
                $response = $client->request('GET', $url, ['timeout' => 10]);
                $html = (string)$response->getBody();
                $pattern = '/<link\s+(?:[^>]*?\s+)?rel=["\'](?:shortcut\s+)?icon["\'](?:[^>]*?\s+)?href=["\']([^"\']+)["\']/i';
                preg_match($pattern, $html, $matches);
                $faviconUrl = $matches[1] ?? null;
                if ($faviconUrl && !preg_match('/^https?:\/\//', $faviconUrl)) {
                    // URLからドメイン名のみを取得
                    $parsedUrl = parse_url($url);
                    $domain = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

                    // ファビコンURLを組み立てる
                    $faviconUrl = rtrim($domain, '/') . '/' . ltrim($faviconUrl, '/');
                }
                preg_match('/<title>([^<]+)<\/title>/i', $html, $matches);
                $title = $matches[1] ?? null;
                $result = Link::updateOrCreate(
                    ['url' => $url],
                    [
                        'title' => $title,
                        'favicon' => $faviconUrl,
                    ]);
                $results[] = $result;
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $results[] = new Link([
                    'url' => $url,
                    'title' => null,
                    'favicon' => null,
                ]);
            } catch (\Exception $e) {
                $results[] = new Link([
                    'url' => $url,
                    'title' => null,
                    'favicon' => null,
                ]);
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'URL fetched successfully',
            'results' => $results,
        ]);
    }

    public function notesUpdate(Request $request) {
        try {
            DB::beginTransaction();
            $notes = Note::where('note_id', $request->id)->delete();
            foreach ($request->contents as $index => $content) {
                $attributes = null;
                if (isset($content['attributes'])) {
                    $attributes = json_encode($content['attributes']);
                }
                $note = Note::create([
                    'note_id' => $request->id,
                    'sort' => $index,
                    'attributes' => $attributes,
                    'insert' => $content['insert'],
                ]);
            }
            $notes = Note::where('note_id', $request->id)->get();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Note registered successfully',
                'note' => $notes,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed register note:'. $e->getMessage(),
            ], 500);
        }
    }
}
