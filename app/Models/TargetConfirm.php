<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetConfirm extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_id',
        'user_id',
    ];
}
