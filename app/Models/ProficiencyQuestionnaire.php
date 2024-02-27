<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function ProficiencyUserQuestionnaire(): HasMany
    {
        return $this->hasMany(ProficiencyUserQuestionnaire::class,'proficiency_questionnaire_id','id');
    }

}
