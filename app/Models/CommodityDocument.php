<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommodityDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'document',
        'year',
        'commodity_id',
        'file_path',
        'description',
    ];
}
