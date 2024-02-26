<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommodityPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'commodity_id',
        'price',
        'description',
    ];

    public function commodity(){
        return $this->belongsTo(Commodity::class);
    }

    public function ProfiencyUserPackage(): HasMany
    {
        return $this->hasMany(ProficiencyUserPackage::class,'package_id','id');
    }
}
