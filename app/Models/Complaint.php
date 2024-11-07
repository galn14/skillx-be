<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';
    protected $primaryKey = 'IdComplaint';

    protected $fillable = [
        'IdTransaction',
        'ComplaintText',
        'Status',
    ];

    public $timestamps = false;
}
