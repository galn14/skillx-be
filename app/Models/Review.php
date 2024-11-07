<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'IdReview';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = null;

    protected $fillable = [
        'UserId',
        'IdTransaction',
        'Rating',
        'Comment',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'IdTransaction', 'IdTransaction');
    }
}
