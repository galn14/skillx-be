<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $primaryKey = 'IdNotification';

    protected $fillable = [
        'UserId',
        'Title',
        'Description',
        'Time'
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'Id');
    }
}
