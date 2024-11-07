<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';
    protected $primaryKey = 'IdSeller';

    protected $fillable = [
        'PhotoProfile',
        'UserId',
        'Universitas',
        'IdMajor',
        'Language',
        'Rating',
        'YearSince',
        'Orders',
        'Level',
        'Description',
        'GraduationMonth',
        'GraduationYear',
        'GraduationValidUntil',
    ];

    // Define the relationship to followers
    public function followers()
    {
        return $this->hasMany(Following::class, 'IdSeller', 'IdSeller');
    }

    // Accessor for follower count
    public function getFollowerCountAttribute()
    {
        return $this->followers()->count();
    }
}
