<?php

// app/Models/UserLogout.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logout_time',
        'ip_address',
        'user_agent',
    ];
}
