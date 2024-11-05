<?php

namespace App\Models\views;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_Mouvement extends Model
{
    use HasFactory;
    protected $table = 'v_mouvements';

    public function pourcentageStock($quantite_inititale, $quantite_finale)
    {
        return ($quantite_finale/$quantite_inititale) * 100;
    }

    function couleurObject($v_mouvement){
        if (Carbon::now() > Carbon::parse($v_mouvement->date_mouvement)->addDays($v_mouvement->duree_limite) && $v_mouvement->duree_limite!=null) return 'blue';
        if($v_mouvement->reste_en_stock < $v_mouvement->seuil_reapprovisionnement) return 'red';
        if($v_mouvement->pourcentage > 100) return 'green';
        // Clamp le pourcentage entre 0 et 100
        $pourcentage = max(0, min(100, $v_mouvement->pourcentage));

        // Calcul de la transition avec des valeurs moins extrêmes pour éviter un vert trop fluo
        $rouge = (int) (200 - (200 * $pourcentage / 100)); // Max à 200 au lieu de 255
        $vert = (int) (150 + (105 * $pourcentage / 100));  // Min à 150, Max à 255

        // Formate la couleur en code hexadécimal
        return sprintf("#%02x%02x00", $rouge, $vert);
    }

    function quantite_seuil($v_mouvement)
    {
        return $v_mouvement->reste_en_stock - $v_mouvement->seuil_reapprovisionnement;
    }

}
