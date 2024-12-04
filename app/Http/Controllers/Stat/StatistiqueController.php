<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use App\Models\produits\Produit;
use App\Models\views\V_MouvementProduitIngredient;
use App\Models\views\V_MouvementStatStockDiagramme;
use App\Models\views\V_Produit;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    //
    public function showStat($code_produit){
        $data['produit'] = V_Produit::where('code', $code_produit)
            ->first();
        $data['v_stat_stocks'] = V_MouvementStatStockDiagramme::where('code_produit', $code_produit)
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        print_r($data['v_stat_stocks']);

    }


}
