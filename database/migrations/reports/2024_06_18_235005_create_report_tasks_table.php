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
        Schema::create('report_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete()->comment('レポートID');
            $table->foreignId('task_id')->constrained()->cascadeOnDelete()->comment('タスクID');
            $table->float('hours')->comment('作業時間');
            $table->integer('progress')->comment('進捗率');
            $table->json('details')->nullable()->comment('詳細');
            $table->json('problems')->nullable()->comment('問題点');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_tasks');
    }
};
