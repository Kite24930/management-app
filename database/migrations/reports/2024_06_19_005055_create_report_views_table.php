<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('create or replace view report_views as select x.id as report_id, x.user_id as user_id, y.name as user_name, y.icon as icon, x.date as date, z.task_id as task_id, a.title as task_title, a.type as task_type, z.hours as hours, z.progress as progress, z.details as details, z.problems as problems, x.announcement as announcement from report_tasks as z left join reports as x on z.report_id = x.id left join users as y on x.user_id = y.id left join tasks as a on z.task_id = a.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_views');
    }
};
