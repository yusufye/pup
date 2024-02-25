<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
