<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
      'categorie',
      'description',
      'type_categorie',
    ];
    public function sousCategories()
    {
        return $this->belongsToMany(Categorie::class, 'sous_categories', 'id_categorie', 'id_sous_categorie')
            ->withTimestamps();
    }

    // Dans un contrôleur ou dans une vue
    function afficherCategories($categories)
    {
        foreach ($categories as $categorie) {
            echo "<ul>";
            echo "<li>" . $categorie->categorie . "</li>";

            if ($categorie->sousCategories->isNotEmpty()) {
                afficherCategories($categorie->sousCategories);
            }

            echo "</ul>";
        }
    }

}
