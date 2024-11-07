<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';
    protected $primaryKey = 'IdWishlist';

    protected $fillable = [
        'UserId',
        'IdProduct',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'id');
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'IdProduct', 'IdProduct');
    }
}
