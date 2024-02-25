<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyUserCommodity extends Model
{
    use HasFactory;

    public function ProficiencyUserPackage(): HasMany
    {
        return $this->hasMany(ProficiencyUserPackage::class);
    }
    
    public function ProficiencyUser(): belongsTo
    {
        return $this->belongsTo(ProficiencyUser::class);
    }
}
