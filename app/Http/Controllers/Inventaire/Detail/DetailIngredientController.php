<?php

namespace App\Http\Controllers\Inventaire\Detail;

use App\Http\Controllers\Controller;
use App\Models\views\V_MouvementInventaireDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailIngredientController extends Controller
{
    //
    public function showInventaireDetailIngredient(Request $request, $code_produit){
        $data['details'] = V_MouvementInventaireDetails::where('code_produit', $code_produit)->get();
        $diagramme_debut = $request->input('diagramme_debut');
        $diagramme_fin = $request->input('diagramme_fin');
        if ($diagramme_debut !== null && $diagramme_fin !== null){
            $data['diagrams'] = DB::select(DB::raw("
            SELECT *
            FROM (
                SELECT *
                FROM v_mouvement_inventaire_detail_diagrammes
                WHERE code_produit = ?
                ORDER BY date DESC
                LIMIT 7
                ) AS sous_requete
                WHERE date >= ? AND date <= ?
                ORDER BY date ASC
                "), [$code_produit, $diagramme_debut, $diagramme_fin]);
        }else{
            $data['diagrams'] = DB::select(DB::raw("
            SELECT *
            FROM (
                SELECT *
                FROM v_mouvement_inventaire_detail_diagrammes
                WHERE code_produit = ?
                ORDER BY date DESC
                LIMIT 7
                ) AS sous_requete
                ORDER BY date ASC
                "), [$code_produit]);
        }
        $data['v'] = new V_MouvementInventaireDetails();
        // print_r($data['diagrams']);
        return view('inventaire/detail/detail-ingredient')->with($data);
    }

}
