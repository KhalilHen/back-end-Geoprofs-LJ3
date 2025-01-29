<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequests extends Model
{
    // use HasFactory;
    protected $table = 'leave_requests';

    protected $fillable = [
        'leave_status', 
    ];
}
