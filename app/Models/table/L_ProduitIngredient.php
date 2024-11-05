<?php

namespace App\Models\table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class L_ProduitIngredient extends Model
{
    use HasFactory;
    protected $table = 'l_produit_ingredients';
    public $incrementing = false;
    protected $fillable = [
      'code_produit',
      'ingredient_code_produit',
      'quantite',
    ];

    public function isChecked($ingredient_code_produit, $produit_ingredients){
        foreach ($produit_ingredients as $pi) if ($ingredient_code_produit == $pi->ingredient_code_produit) return [true, $pi->quantite]  ;
        return [false, null];
    }
}
