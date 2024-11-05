<?php

namespace App\Models\produits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonConsommable extends Model
{
    use HasFactory;
    protected $table = 'produits';
    public $incrementing = false;
    protected $fillable = [
        'code',
        'nom',
        'description',
        'id_categorie',
        'unite',
        'seuil_reapprovisionnement',
    ];
}
