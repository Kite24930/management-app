<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'task_id',
        'hours',
        'progress',
        'details',
        'problems'
    ];
}
