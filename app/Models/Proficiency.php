<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProficiencyQuestionnaire;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proficiency extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'years',
        'show_report'
    ];
    
    public function commodity()
    {
        return $this->hasMany(Commodity::class);
    }

    public function ProficiencyQuestionnaire()
    {
        return $this->hasMany(ProficiencyQuestionnaire::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'proficiency_users');
    }
    public function ProficiencyUser(): HasMany
    {
        return $this->hasMany(Proficiency::class, 'proficiency_id','id');
    }
}
