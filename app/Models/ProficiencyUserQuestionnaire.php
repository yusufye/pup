<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyUserQuestionnaire extends Model
{
    use HasFactory;
    
    public function ProficiencyUser(): belongsTo
    {
        return $this->belongsTo(ProficiencyUser::class);
    }
}
