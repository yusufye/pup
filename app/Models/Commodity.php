<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent',
        'proficiency_id',
        'description',
    ];

    public function package(): HasMany
    {
        return $this->hasMany(CommodityPackage::class);
    }
    
    public function document(): HasMany
    {
        return $this->hasMany(CommodityDocument::class);
    }

    public function proficiency()
    {
        return $this->belongsTo(Proficiency::class);
    }
}