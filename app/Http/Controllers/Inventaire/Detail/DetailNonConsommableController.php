<?php

namespace App\Http\Controllers\Inventaire\Detail;

use App\Http\Controllers\Controller;
use App\Models\views\V_MouvementInventaireDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailNonConsommableController extends Controller
{
    //
    public function showInventaireDetailNonConsommable($code_produit){
        $data['details'] = V_MouvementInventaireDetails::where('code_produit', $code_produit)->get();
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
        $data['v'] = new V_MouvementInventaireDetails();
        return view('inventaire/detail/detail-non-consommable')->with($data);
    }
}
