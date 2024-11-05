<?php

namespace App\Models\produits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{

    use HasFactory;
    public $table = 'produits';
    public $incrementing = false;

    public $fillable = [
        'code',
        'nom',
        'description',
        'id_categorie',
        'unite',
        'seuil_reapprovisionnement',
        'limite_date',
    ];

    public function __construct(array $attributes = [])
    {
        // $this->setAttribute('est_ingredient', 1);
        parent::__construct($attributes);
    }

}
