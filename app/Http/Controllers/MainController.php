<?php

namespace App\Http\Controllers;

use App\Models\CancelList;
use App\Models\Comment;
use App\Models\CompletedList;
use App\Models\CompletedTask;
use App\Models\Department;
use App\Models\Link;
use App\Models\Note;
use App\Models\OtherList;
use App\Models\OtherTask;
use App\Models\PendingList;
use App\Models\ProgressList;
use App\Models\ProgressTask;
use App\Models\Report;
use App\Models\ReportAnnouncement;
use App\Models\ReportConfirm;
use App\Models\ReportConfirmView;
use App\Models\ReportDetail;
use App\Models\ReportProblem;
use App\Models\ReportTask;
use App\Models\ReportView;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\TaskLog;
use App\Models\TaskMember;
use App\Models\TaskType;
use App\Models\ToDoList;
use App\Models\ToDoTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function index() {
        if (AUth::user()->first_login === null) {
            return redirect()->route('profile.first-login');
        }
        $data = [

        ];
        return view('index', $data);
    }

    public function tasks($id = 0) {
        $active_user = Auth::user();
        $target = TaskList::find($id);
        $tasks = TaskList::where('parent_id', $id);
        $task_list = $tasks->pluck('id')->toArray();
        $tasks = $tasks->get();
        $members = [];
        $comments = [];
        $log = [];
        foreach ($task_list as $task_id) {
            $member = TaskMember::where('task_id', $task_id);
            if ($member->count() > 0) {
                $members[$task_id] = $member->pluck('member_id')->toArray();
            } else {
                $members[$task_id] = [];
            }
            $comments[$task_id] = Comment::where('task_id', $task_id)->get();
            $log[$task_id] = TaskLog::where('task_id', $task_id)->get();
        }
        $todo = ToDoList::whereIn('task_id', $task_list)->orderBy('id')->get();
        $progress = ProgressList::whereIn('task_id', $task_list)->orderBy('id')->get();
        $pending = PendingList::whereIn('task_id', $task_list)->orderBy('id')->get();
        $completed = CompletedList::whereIn('task_id', $task_list)->orderBy('id')->get();
        $other = OtherList::whereIn('task_id', $task_list)->orderBy('id')->get();
        $cancel = CancelList::whereIn('task_id', $task_list)->orderBy('id')->get();
        $users = User::all();
        $departments = Department::all();
        $task_types = TaskType::all();
        $data = compact('target', 'task_list', 'tasks', 'members', 'comments', 'todo', 'progress', 'pending', 'completed', 'other', 'cancel', 'log', 'active_user', 'users', 'departments', 'task_types');
        return view('tasks', $data);
    }

    public function admin() {
        $data = [

        ];
        return view('auth.admin', $data);
    }

    public function adminDepartment() {
        $data = [
            'departments' => Department::all(),
        ];
        return view('auth.admin.department', $data);
    }

    public function adminUsersList() {
        $data = [
            'users' => User::all(),
            'departments' => Department::all(),
        ];
        return view('auth.admin.users-list', $data);
    }

    public function notes() {
        $data = [
            'users' => User::all(),
        ];
        return view('notes', $data);
    }

    public function notesView($id) {
        $data = [
            'note_user' => User::find($id),
            'user' => Auth::user(),
            'id' => $id,
            'notes' => Note::select('attributes', 'insert')->where('note_id', $id)->orderBy('sort')->get(),
            'links' => Link::all(),
        ];
        return view('notes.viewing', $data);
    }

    public function notesEdit($id) {
        $data = [
            'note_user' => User::find($id),
            'user' => Auth::user(),
            'id' => $id,
            'notes' => Note::select('attributes', 'insert')->where('note_id', $id)->orderBy('sort')->get(),
            'links' => Link::all(),
        ];
        return view('notes.edit', $data);
    }

    public function notesEditPost($id, Request $request) {

    }

    public function reports() {
        $reports = ReportView::select('report_id', 'user_id', 'user_name', 'date')->distinct()->get();
        $data = [
            'users' => User::all(),
            'reports' => $reports,
        ];
        return view('reports.reports', $data);
    }

    public function reportsView($id) {
        $report = Report::find($id);
        $confirm_check = ReportConfirm::where('report_id', $id)->where('user_id', Auth::user()->id)->count();
        if ($confirm_check > 0) {
            $confirm = false;
        } else {
            $confirm = true;
        }
        $data = [
            'report' => $report,
            'tasks' => ReportView::where('report_id', $id)->get(),
            'user' => User::find($report->user_id),
            'login_user' => Auth::user(),
            'confirm' => ReportConfirmView::where('report_id', $id)->get(),
            'confirm_check' => $confirm,
        ];
        return view('reports.view', $data);
    }

    public function reportsConfirm($id) {
        $data = [
            'report_id' => $id,
            'user_id' => Auth::user()->id,
        ];
        ReportConfirm::create($data);
        return redirect()->route('reports.view', $id)->with('message', 'Report confirmed successfully');
    }

    public function reportsAdd() {
        $my_tasks = TaskMember::where('member_id', Auth::user()->id)->pluck('task_id')->toArray();
        $tasks = Task::whereIn('id', $my_tasks)->whereNotIn('status', [3, 5])->where('parent_id', 0)->get();
        $data = [
            'user' => User::find(Auth::user()->id),
            'tasks' => $tasks,
        ];
        return view('reports.add', $data);
    }

    public function reportsAddPost(Request $request) {
        $request->validate([
            'date' => 'required|date',
            'announcement' => 'required',
            'tasks' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $report = Report::create([
                'user_id' => Auth::user()->id,
                'date' => $request->date,
                'announcement' => $request->announcement,
            ]);
            $tasks = [];
            foreach ($request->tasks as $data) {
                if ($data['task'] === null || $data['hours'] === null || $data['progress'] === null || $data['details'] === null || $data['problems'] === null) {
                    DB::rollBack();
                    return ['status' => 'error', 'message' => 'Please fill all fields'];
                }
                $task = ReportTask::create([
                    'report_id' => $report->id,
                    'task_id' => $data['task'],
                    'hours' => $data['hours'],
                    'progress' => $data['progress'],
                    'details' => $data['details'],
                    'problems' => $data['problems'],
                ]);
                $tasks[] = $task;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
        return ['status' => 'success', 'message' => 'Report added successfully', 'report' => $report, 'tasks' => $tasks, 'redirect' => route('reports.send', $report->id)];
    }

    public function reportsSend($id) {
        $report = Report::find($id);
        $confirm_check = ReportConfirm::where('report_id', $id)->where('user_id', Auth::user()->id)->count();
        if ($confirm_check > 0) {
            $confirm = false;
        } else {
            $confirm = true;
        }
        $data = [
            'report' => $report,
            'tasks' => ReportView::where('report_id', $id)->get(),
            'user' => User::find($report->user_id),
            'confirm' => ReportConfirmView::where('report_id', $id)->get(),
            'confirm_check' => $confirm,
        ];
        return view('reports.send', $data);
    }

    public function reportsSendPost(Request $request) {
        try {
            Mail::send('reports.mail', ['html' => $request->html], function ($message) use ($request) {
                $message->to('main@mie-projectm.com');
                $message->subject($request->reporter . ' on ' . date('y-m-d', strtotime($request->date)));
                $message->from(env('DAILY_REPORT_RECEIVER'), 'Project M Daily Report');
                $message->cc(env('DAILY_REPORT_RECEIVER'));
            });

            return ['status' => 'success', 'message' => 'Report sent successfully', 'request' => $request->all()];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function reportsEdit($id) {
        $report = Report::find($id);
        $my_tasks = TaskMember::where('member_id', Auth::user()->id)->pluck('task_id')->toArray();
        $tasks = Task::whereIn('id', $my_tasks)->whereNotIn('status', [3, 5])->where('parent_id', 0)->get();
        $data = [
            'report' => $report,
            'report_tasks' => ReportView::where('report_id', $id)->get(),
            'tasks' => $tasks,
            'user' => User::find($report->user_id),
        ];
        return view('reports.edit', $data);
    }

    public function reportsEditPost($id, Request $request) {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'date' => 'required|date',
            'announcement' => 'required',
            'tasks' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $report = Report::find($request->report_id);
            $report->update([
                'date' => $request->date,
                'announcement' => $request->announcement,
            ]);
            ReportTask::where('report_id', $report->id)->delete();
            $tasks = [];
            foreach ($request->tasks as $data) {
                if ($data['task'] === null || $data['hours'] === null || $data['progress'] === null || $data['details'] === null || $data['problems'] === null) {
                    DB::rollBack();
                    return ['status' => 'error', 'message' => 'Please fill all fields'];
                }
                $task = ReportTask::create([
                    'report_id' => $report->id,
                    'task_id' => $data['task'],
                    'hours' => $data['hours'],
                    'progress' => $data['progress'],
                    'details' => $data['details'],
                    'problems' => $data['problems'],
                ]);
                $tasks[] = $task;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
        return ['status' => 'success', 'message' => 'Report edited successfully', 'report' => $report, 'tasks' => $tasks];
    }

    public function reportsDelete($id) {
        Report::find($id)->delete();
        return redirect()->route('reports');
    }

    public function reportsTaskComponents(Request $request) {
        $tasks = $request->tasks;
        $num = $request->num + 1;
        return response()->json([
            'view' => view('components.self.report-task', compact('tasks', 'num'))->render(),
            'num' => $num,
        ]);
    }
}
