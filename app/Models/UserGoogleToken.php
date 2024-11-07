<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGoogleToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'google_id',
        'access_token',
        'refresh_token',
        'expires_at',
    ];

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
