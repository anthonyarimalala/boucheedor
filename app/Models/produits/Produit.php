<?php

namespace App\Models\produits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produit extends Model
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
        'transfomation_locale',
        'est_stockable',
        'est_consommable',
        'duree_limite',
    ];


    public static function generateCode($prefix, $length, $sequenceName){
        $nextVal = DB::select("SELECT nextval(?) AS seq", [$sequenceName]);
        $seqValue = $nextVal[0]->seq;
        $formattedSeq = str_pad($seqValue, $length, '0', STR_PAD_LEFT);
        return $prefix.$formattedSeq;
    }

}
