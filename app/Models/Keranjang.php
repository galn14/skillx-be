<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs';
    protected $primaryKey = 'IdKeranjang';
    protected $fillable = [
        'IdProduct',
        'UserId',
        'Quantity',
    ];

    // Relasi ke tabel Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'IdProduct', 'IdProduct');
    }

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'Id');
    }
}
