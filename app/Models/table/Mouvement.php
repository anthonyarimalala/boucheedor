<?php

namespace App\Models\table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model
{
    use HasFactory;
    protected $table = 'mouvements';
    protected $fillable = [
        'code_produit',
        'id_emplacement',
        'entree',
        'sortie',
        'date_mouvement',
    ];
}
