<?php

namespace App\Http\Controllers;

use App\Models\CancelList;
use App\Models\Comment;
use App\Models\CompletedList;
use App\Models\CompletedTask;
use App\Models\OtherList;
use App\Models\OtherTask;
use App\Models\PendingList;
use App\Models\ProgressList;
use App\Models\ProgressTask;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\TaskLog;
use App\Models\TaskMember;
use App\Models\ToDoList;
use App\Models\ToDoTask;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $data = [

        ];
        return view('index', $data);
    }

    public function tasks($id = 0) {
        $target = TaskList::find($id);
        $tasks = TaskList::where('parent_id', $id);
        $task_list = $tasks->pluck('id')->toArray();
        $tasks = $tasks->get();
        $members = [];
        $comments = [];
        $todo = [];
        $progress = [];
        $pending = [];
        $completed = [];
        $other = [];
        $cancel = [];
        $log = [];
        foreach ($task_list as $task_id) {
            $member = TaskMember::where('task_id', $task_id);
            if ($member->count() > 0) {
                $members[$task_id] = $member->pluck('member_id')->toArray();
            } else {
                $members[$task_id] = [];
            }
            $comments[$task_id] = Comment::where('task_id', $task_id)->get();
            switch (Task::find($task_id)->status) {
                case 0:
                    $todo[$task_id] = ToDoList::where('task_id', $task_id)->first();
                    break;
                case 1:
                    $progress[$task_id] = ProgressList::where('task_id', $task_id)->first();
                    break;
                case 2:
                    $pending[$task_id] = PendingList::where('task_id', $task_id)->first();
                    break;
                case 3:
                    $completed[$task_id] = CompletedList::where('task_id', $task_id)->first();
                    break;
                case 4:
                    $other[$task_id] = OtherList::where('task_id', $task_id)->first();
                    break;
                case 5:
                    $cancel[$task_id] = CancelList::where('task_id', $task_id)->first();
                    break;
            }
            $log[$task_id] = TaskLog::where('task_id', $task_id)->get();
        }
        $data = compact('target', 'task_list', 'tasks', 'members', 'comments', 'todo', 'progress', 'pending', 'completed', 'other', 'cancel', 'log');
        return view('tasks', $data);
    }
}
