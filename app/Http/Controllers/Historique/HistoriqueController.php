<?php

namespace App\Http\Controllers\Historique;

use App\Http\Controllers\Controller;
use App\Models\views\V_MouvementHistorique;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
    //

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
