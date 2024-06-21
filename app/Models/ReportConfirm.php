<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportConfirm extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'user_id',
    ];
}
