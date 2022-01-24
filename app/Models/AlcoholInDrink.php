<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlcoholInDrink extends Model
{
    use HasFactory;

    protected $fillable = [
        'drink_id',
        'alcohol_id',
        'alcohol_unit',
        'alcohol_amount',
    ];
}
