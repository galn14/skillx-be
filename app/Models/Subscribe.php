<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari default (default: nama model dalam bentuk plural)
    protected $table = 'subscribes';

    // Primary key kustom jika berbeda dari 'id'
    protected $primaryKey = 'IdSubscribe';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'UserId',
        'Month',
        'start_date',
        'end_date',
    ];

    // Tentukan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'id');
    }
}
