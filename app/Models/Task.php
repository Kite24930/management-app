<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'parent_id',
        'type',
        'description',
        'priority',
        'start_date',
        'end_date',
        'icon',
        'created_by',
        'status',
    ];
}
