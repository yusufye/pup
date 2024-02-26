<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProficiencyUserPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'proficiency_user_commodity_id',
        'package_id',
    ];

    public function ProficiencyUserCommodity(): BelongsTo
    {
        return $this->belongsTo(ProficiencyUserCommodity::class,'proficiency_user_commodity_id','id');
    }
    public function package(): BelongsTo
    {
        return $this->belongsTo(CommodityPackage::class,'package_id','id');
    }
}
