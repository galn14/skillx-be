<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;

    protected $table = 'followings';
    protected $primaryKey = 'IdFollow';

    protected $fillable = [
        'IdFollower',
        'IdSeller',
    ];

    // Define relationships
    public function follower()
    {
        return $this->belongsTo(User::class, 'IdFollower', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'IdSeller', 'IdSeller');
    }
}
