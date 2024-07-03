<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_date',
        'due_date',
        'issue_user_id',
        'client_name',
        'subject',
        'amount',
        'description',
        'file_name',
        'passed_date',
        'passed_user_id',
        'payment_date',
        'payment_user_id',
    ];

    public function issueUser()
    {
        return $this->belongsTo(User::class, 'issue_user_id');
    }

    public function passedUser()
    {
        return $this->belongsTo(User::class, 'passed_user_id');
    }

    public function paymentUser()
    {
        return $this->belongsTo(User::class, 'payment_user_id');
    }
}
