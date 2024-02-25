<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyUserPackage extends Model
{
    use HasFactory;
    public function ProficiencyUserCommodity(): belongsTo
    {
        return $this->belongsTo(ProficiencyUserCommodity::class);
    }
}
