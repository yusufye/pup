<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProficiencyUserQuestionnaire extends Model
{
    use HasFactory;
    
    public function ProficiencyUser(): BelongsTo
    {
        return $this->belongsTo(ProficiencyUser::class);
    }

    public function ProficiencyQuestionnaires(): BelongsTo
    {
        return $this->belongsTo(ProficiencyQuestionnaire::class,'proficiency_questionnaire_id','id');
    }
}
