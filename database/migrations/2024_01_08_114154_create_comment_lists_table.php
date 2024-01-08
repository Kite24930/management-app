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
        DB::statement('create or replace view comment_lists as select x.id as id, x.task_id as task_id, x.user_id as user_id, y.name as name, y.icon as icon, y.belong_to as belong_to, y.post as post, x.comment as comment, x.created_at as created_at, x.updated_at as updated_at from comments as x left join users as y on x.user_id = y.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_lists');
    }
};
