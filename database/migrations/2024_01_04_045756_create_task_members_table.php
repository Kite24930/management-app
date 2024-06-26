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
        Schema::create('task_members', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->comment('ユーザーID');
            $table->foreignId('task_id')->constrained()->onDelete('cascade')->comment('タスクID');
            $table->tinyinteger('is_main_person')->comment('メイン担当者かどうか');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_members');
    }
};
