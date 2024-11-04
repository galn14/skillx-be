<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'IdProduct';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'NamaProduct',
        'DeskripsiProduct',
        'FotoProduct',
        'Price',
        'IdMajor',
        'ServicesId',
        'IdSeller',
    ];

    // Define relationships
    public function major()
    {
        return $this->belongsTo(Major::class, 'IdMajor', 'IdMajor');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'ServicesId', 'IdServices');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'IdSeller', 'id');
    }
}
