<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'SenderId',
        'ReceiverId',
        'MessageTitle',
        'MessageContent',
    ];

    // Relasi dengan pengguna pengirim
    public function sender()
    {
        return $this->belongsTo(User::class, 'SenderId');
    }

    // Relasi dengan pengguna penerima
    public function receiver()
    {
        return $this->belongsTo(User::class, 'ReceiverId');
    }
}
