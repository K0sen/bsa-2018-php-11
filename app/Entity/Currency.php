<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        "id",
        "name"
    ];

    public function lots()
    {
        return $this->hasMany(\App\Models\Lot::class);
    }

    public function money()
    {
        return $this->hasMany(\App\Models\Money::class);
    }
}
