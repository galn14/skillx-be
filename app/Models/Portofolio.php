<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolios';
    protected $primaryKey = 'IdPortofolio';

    protected $fillable = [
        'UserId',
        'TitlePortofolio',
        'DescriptionPortofolio',
        'LinkPortofolio',
        'PhotoPortofolio',
        'TypePortofolio',
        'StatusPortofolio',
        'DateCreatedPortofolio',
        'DateEndPortofolio',
        'IsPresentPortofolio',
    ];
}
