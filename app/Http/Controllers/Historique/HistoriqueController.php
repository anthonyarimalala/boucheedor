<?php

namespace App\Http\Controllers\Historique;

use App\Http\Controllers\Controller;
use App\Models\Mouvement;
use App\Models\produits\Produit;
use App\Models\views\V_Mouvement;
use App\Models\views\V_MouvementHistorique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriqueController extends Controller
{
    //

    public function showMouvement($id_mouvement)
    {
        $data['mouvement'] = V_MouvementHistorique::where('id', $id_mouvement)->first();
        $data['raison_mouvements'] = DB::SELECT("SELECT * FROM raison_mouvements");
        return view('historique/modifier/modifier-mouvement')->with($data);
    }
    public function updateHistorique(Request $request)
    {
        $code = $request->input('code');
        $type_mouvement = $request->input('type_mouvement');
        $m_produit = Produit::where('code', $code)->first();
        if ($type_mouvement == 'sortie') {
            $sortie = $request->input('sortie');
            $m_produit->sortie = $sortie;
        } else if ($type_mouvement == 'entree'){
            $entree = $request->input('entree');
            $prix_unitaire = $request->input('prix_unitaire');
            $m_produit->entree = $entree;
            $m_produit->prix_unitaire = $prix_unitaire;
        }
        $m_produit->save();
        return back()->with('success', 'Modification réussite.');
    }


    public function showHistorique(Request $request){
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $data['is_pagined'] = false;

        if ($date_debut != null){
            $data['v_historiques'] = V_MouvementHistorique::where('date_mouvement','>=',$date_debut)
                ->get();
        }else if($date_fin != null){
            $data['v_historiques'] = V_MouvementHistorique::where('date_mouvement', '<=', $date_fin)
                ->get();
        }else if ($date_debut!=null && $date_fin!=null){
            $data['v_historiques'] = V_MouvementHistorique::where('date_mouvement','>=',$date_debut)
                ->where('date_mouvement', '<=', $date_fin)
                ->get();
        }else{
            $data['v_historiques'] = V_MouvementHistorique::paginate(20);
            $data['is_pagined'] = true;
        }
        return view('historique/historique-mouvement')->with($data);
    }
}
