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
        DB::statement('create or replace view report_confirm_views as select x.report_id as report_id, x.user_id as user_id, y.name as user_name, y.icon as icon, x.created_at as created_at from report_confirms as x left join users as y on x.user_id = y.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_confirm_views');
    }
};
