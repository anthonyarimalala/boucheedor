<?php

namespace App\Http\Controllers\Cout;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Emplacement;
use App\Models\views\V_Mouvement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoutController extends Controller
{
    //
    public function showRechercheCout(){
        $data['objets'] = V_Mouvement::where('reste_en_stock','!=', 0)
            ->where('emplacement', '!=', '')
            ->get();
        $data['emplacements'] = DB::select('SELECT emplacement FROM emplacements WHERE emplacement != ? GROUP BY emplacement ', ['']);
        $data['categories'] = DB::select('SELECT categorie FROM categories GROUP BY categorie');
        return view('cout/detail/recherche-cout')->with($data);
    }
    public function showCoutTypeCategorie(){
        $data['objets'] = DB::select('
            SELECT
                type_categorie,
                SUM(prix_total) AS prix_total
            FROM v_mouvements
            WHERE emplacement != ?
            GROUP BY type_categorie
        ', ['']);
        $data['total'] = DB::select('
            SELECT
                COALESCE(SUM(prix_total), 0) AS prix_total
            FROM v_mouvements m
            WHERE emplacement != ?
        ', ['']);

        return view('cout/cout')->with($data);
    }

    public function showDetailCoutProduit($type_categorie){
        $data['objets'] = DB::select('
            SELECT
                code_produit,
                nom,
                emplacement,
                reste_en_stock,
                prix_unitaire,
                categorie,
                type_categorie,
                prix_total
            FROM v_mouvements
            WHERE type_categorie = ? AND reste_en_stock != 0 AND emplacement != ?
        ', [$type_categorie, '']);
        return view('cout/detail/detail-cout')->with($data);
    }
}
