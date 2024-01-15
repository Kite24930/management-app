<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\TaskType;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 共有変数
        $users = User::all();
        $departments = Department::all();
        $task_types = TaskType::all();
        view()->share(compact('users', 'departments', 'task_types'));
        if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
