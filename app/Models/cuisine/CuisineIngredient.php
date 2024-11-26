<?php

namespace App\Models\cuisine;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuisineIngredient extends Model
{
    use HasFactory;
    protected $table = 'cuisine_ingredients';
}
