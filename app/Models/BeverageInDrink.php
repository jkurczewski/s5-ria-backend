<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeverageInDrink extends Model
{
    use HasFactory;

    protected $fillable = [
        'drink_id',
        'beverage_id',
        'beverage_unit',
        'beverage_amount',
    ];
}
