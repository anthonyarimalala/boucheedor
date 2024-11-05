<?php

namespace App\Models\views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_MouvementInventaireDetails extends Model
{
    use HasFactory;
    protected $table = 'v_mouvement_inventaire_details';

    public function mouvementColor($v)
    {
        if ($v->entree == null){
            return '#ffa6a6';
        }
        return 'lightgreen';
    }
}
