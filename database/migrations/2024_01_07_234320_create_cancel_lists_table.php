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
        DB::statement('create or replace view cancel_lists as select x.id as id, x.task_id as task_id, y.title as title, y.parent_id as parent_id, y.parent_title as parent_title, y.type as type, y.description as description, y.priority as priority, y.start_date as start_date, y.end_date as end_date, y.icon as icon, y.created_by as created_by, y.person_name as person_name, y.person_icon as person_icon, y.belong_to as belong_to, y.post as post, y.main_person_id as main_person_id, y.main_person_name as main_person_name, y.main_person_icon as main_person_icon, y.main_person_belong_to as main_person_belong_to, y.main_person_post as main_person_post from cancel_tasks as x left join task_lists as y on x.task_id = y.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_lists');
    }
};
