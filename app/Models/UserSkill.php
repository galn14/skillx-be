<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $table = 'user_skills';

    protected $fillable = [
        'UserId',
        'IdSkill',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'IdSkill', 'IdSkill');
    }
}
