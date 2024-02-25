<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyUser extends Model
{
    use HasFactory;

    public function ProficiencyUserCommodity(): HasMany
    {
        return $this->hasMany(ProficiencyUserCommodity::class);
    }

    public function ProficiencyUserQuestionnaire(): HasMany
    {
        return $this->hasMany(ProficiencyUserQuestionnaire::class);
    }
}
