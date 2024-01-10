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
        Schema::create('member_lists', function (Blueprint $table) {
            DB::statement('create or replace view member_lists as select x.member_id as id, x.task_id as task_id, x.is_main_person as is_main_person, y.name as name, y.email as email, y.icon as icon, y.belong_to as belong_to, y.post as post from task_members as x left join users as y on x.member_id = y.id;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_lists');
    }
};
