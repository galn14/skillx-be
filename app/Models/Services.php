<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'IdServices';

    protected $fillable = [
        'NamaServices',
        'IdMajor',
        'LogoServices',
    ];

    // Define a relationship with the Major model
    public function major()
    {
        return $this->belongsTo(Major::class, 'IdMajor', 'IdMajor');
    }
}
