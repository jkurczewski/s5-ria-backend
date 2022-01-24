<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionInDrink extends Model
{
    use HasFactory;

    protected $fillable = [
        'drink_id',
        'addition_id',
        'addition_unit',
        'addition_amount',
    ];
}
