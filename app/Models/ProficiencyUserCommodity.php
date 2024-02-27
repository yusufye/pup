<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProficiencyUserCommodity extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'proficiency_user_id',
        'commodity_id',
        'client_document',
    ];


    public function ProficiencyUserPackage(): HasMany
    {
        return $this->hasMany(ProficiencyUserPackage::class,'proficiency_user_commodity_id','id');
    }

    public function Commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class,'commodity_id','id');
    }

    public function CommodityPackages(): BelongsTo
    {
        return $this->belongsTo(CommodityPackage::class,'commodity_id','id');
    }
    
    public function ProficiencyUser(): BelongsTo
    {
        return $this->belongsTo(ProficiencyUser::class,'proficiency_user_id','id');
    }
}
