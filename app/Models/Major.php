<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';
    protected $primaryKey = 'IdMajor'; // Define the custom primary key
    public $incrementing = true; // If it’s an auto-incremented integer
    protected $keyType = 'int';

    protected $fillable = [
        'NamaMajor',
        'LogoMajor',
    ];
}
