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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->comment('親タスクID');
            $table->integer('type')->comment('タスクタイプ');
            $table->longText('description')->nullable()->comment('タスク内容');
            $table->integer('priority')->comment('優先度');
            $table->date('start_date')->nullable()->comment('開始日');
            $table->date('end_date')->nullable()->comment('終了日');
            $table->string('icon')->nullable()->comment('アイコン');
            $table->integer('created_by')->comment('作成者');
            $table->integer('status')->comment('ステータス 0:TODO、1:progress、2:pending、3:Completed、4:other、5:cancel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
