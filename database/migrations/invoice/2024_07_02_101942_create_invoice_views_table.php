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
        DB::statement('create or replace view invoice_views as select x.id as id, x.issue_date as issue_date, x.due_date as due_date, x.issue_user_id as issue_user_id, a.name as issue_user_name, a.icon as issue_user_icon, x.client_name as client_name, x.subject as subject, x.amount as amount, x.description as description, x.file_name as file_name, x.passed_date as passed_date, x.passed_user_id as passed_user_id, b.name as passed_user_name, b.icon as passed_user_icon, x.payment_date as payment_date, x.payment_user_id as payment_user_id, c.name as payment_user_name, c.icon as payment_user_icon, x.created_at as created_at, x.updated_at as updated_at from invoices as x left join users as a on x.issue_user_id = a.id left join users as b on x.passed_user_id = b.id left join users as c on x.payment_user_id = c.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_views');
    }
};
