<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('issue_date')->comment('発行日');
            $table->date('due_date')->comment('支払期限');
            $table->foreignId('issue_user_id')->constrained('users')->onDelete('cascade')->comment('発行者');
            $table->string('client_name')->comment('クライアント名');
            $table->string('subject')->comment('件名');
            $table->integer('amount')->comment('金額');
            $table->text('description')->nullable()->comment('詳細');
            $table->string('file_name')->comment('ファイル名');
            $table->date('passed_date')->nullable()->comment('請求日');
            $table->foreignId('passed_user_id')->nullable()->constrained('users')->onDelete('cascade')->comment('請求者');
            $table->date('payment_date')->nullable()->comment('支払日');
            $table->foreignId('payment_user_id')->nullable()->constrained('users')->onDelete('cascade')->comment('支払者');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
