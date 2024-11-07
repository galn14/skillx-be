<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'IdTransaction';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'IdSeller',
        'IdSellerFeat',
        'IdBuyer',
        'IdProduct',
        'Price',
        'TotalPrice',
        'TransactionStatus',
    ];

    // Define relationships if needed
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'IdSeller', 'IdSeller');
    }

    public function featuredSeller()
    {
        return $this->belongsTo(Seller::class, 'IdSellerFeat', 'IdSeller');
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'IdBuyer', 'IdBuyer');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'IdProduct', 'IdProduct');
    }
}
