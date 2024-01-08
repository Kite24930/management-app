<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'title',
        'parent_id',
        'type',
        'description',
        'priority',
        'start_date',
        'end_date',
        'icon',
        'updated_by',
        'updated_version',
        'status',
    ];
}
