<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProficiencyUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'proficiency_id',
        'client_id',
        'user_id',
        'client_sertificate',
        'client_report',
    ];

    public function ProficiencyUserCommodity(): HasMany
    {
        return $this->hasMany(ProficiencyUserCommodity::class,'proficiency_user_id','id');
    }

    public function ProficiencyUserQuestionnaire(): HasMany
    {
        return $this->hasMany(ProficiencyUserQuestionnaire::class);
    }

    public function Proficiency(): BelongsTo
    {
        return $this->belongsTo(Proficiency::class,'proficiency_id','id');
    }
}
