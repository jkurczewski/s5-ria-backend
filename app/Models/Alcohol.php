<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alcohol extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alcohol_name',
        'alcohol_type',
        'alcohol_strength',
        'alcohol_profile_smell',
        'alcohol_profile_taste',
        'alcohol_profile_finish',
        'alcohol_image_url',
    ];
}
