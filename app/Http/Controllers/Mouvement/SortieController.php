<?php

namespace App\Http\Controllers\Mouvement;

use App\Http\Controllers\Controller;
use App\Models\Mouvement;
use App\Models\produits\Produit;
use App\Models\views\V_Mouvement;
use App\Models\views\V_Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SortieController extends Controller
{
    //
    public function createSortieProduit(Request $request){
        $stocks = $request->input('stocks');
        $non_stockables = $request->input('non_stockables');
        $date = $request->input('date');
        $id_raison = $request->input('id_raison');
        // print($id_raison);

        if ($date == null) $date = Carbon::now();
        if ($non_stockables != null){
            foreach ($non_stockables as $non_stockable => $quantite){
                $split = explode(',', $non_stockable);
                if ($quantite != null){
                    $mouvement = new Mouvement();
                    $mouvement->code_produit = $split[0];
                    $mouvement->id_emplacement = $split[1];
                    $mouvement->entree = $quantite;
                    $mouvement->sortie = $quantite;
                    $mouvement->date_mouvement = $date;
                    $mouvement->id_raison = $id_raison;
                    $mouvement->is_validate = 0;
                    $mouvement->save();
                    print($id_raison);
                }
            }
        }
        if ($stocks != null){
            foreach ($stocks as $code => $quantite){ // quantité
                $split = explode(',', $code); // [0]=code_produit; [1]=id_emplacement
                if ($quantite != null){
                    // print($id_raison);
                    Mouvement::mouvementSortie($split[0], $split[1], $quantite, $date, 'desc', $id_raison); // 20 pour sortie
                }
            }
        }
        return back()->with('success', 'Sorties validées');

    }
    public function createPageSortieProduit(Request $request){
        $data['v_stocks'] = V_Stock::where('type_categorie', 'Produit')
            ->where('reste', '!=', 0)
            ->orderBy('nom')->get();
        $data['non_stockables'] = Produit::where('est_stockable', 0)->get();
        $data['produit_notif'] = $request->input('produit');
        return view('sortie/sortie-produit')->with($data);
    }
    public function createPageSortieIngredient(Request $request){
        $data['v_stocks'] = V_Stock::where('type_categorie', 'Ingredient')
            ->where('reste', '!=', 0)
            ->orderBy('nom')->get();
        $data['produit_notif'] = $request->input('produit');
        return view('sortie/sortie-ingredient')->with($data);
    }
    public function createPageSortieNonConsommable(Request $request){
        $data['v_stocks'] = V_Stock::where('type_categorie', 'Non_consommable')
            ->where('reste', '!=', 0)
            ->orderBy('nom')->get();
        $data['produit_notif'] = $request->input('produit');
        return view('sortie/sortie-non-consommable')->with($data);
    }
}
