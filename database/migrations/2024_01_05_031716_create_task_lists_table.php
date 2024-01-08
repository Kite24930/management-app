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
        DB::statement('create or replace view task_lists as select x.id as id, x.title as title, x.parent_id as parent_id, y.title as parent_title, x.type as type, x.description as description, x.priority as priority, x.start_date as start_date, x.end_date as end_date, x.status as status, x.icon as icon, x.created_by as created_by, z.name as person_name, z.icon as person_icon, z.belong_to as belong_to, z.post as post, a.member_id as main_person_id, b.name as main_person_name, b.icon as main_person_icon, b.belong_to as main_person_belong_to, b.post as main_person_post from tasks as x left join tasks as y on x.parent_id = y.id left join users as z on x.created_by = z.id left join task_members as a on x.id = a.task_id and a.is_main_person = 1 left join users as b on a.member_id = b.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_lists');
    }
};
