<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyQuestionnaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'item'
    ];

    public function proficiency()
    {
        return $this->belongsTo(Proficiency::class);
    }

}
