<?php

namespace App\Http\Controllers\Mouvement;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Crud\EmplacementController;
use App\Models\Emplacement;
use App\Models\Mouvement;
use App\Models\produits\Produit;
use App\Models\views\V_Emplacement;
use App\Models\views\V_Produit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EntreeController extends Controller
{
    //
    public function createEntreeProduit(Request $request)
    {
        $produits = $request->input('produits');

        $date = $request->input('date');
        if ($date == null) $date = Carbon::now();
        foreach ($produits as $code => $valeur){
            if ($valeur != null || $valeur != 0){
                $prix_achat = $request->input('prix-achat-'.$code);

                $m_mouvement = new Mouvement();
                $m_mouvement->code_produit = $code;
                $m_mouvement->entree = $valeur;
                $m_mouvement->prix_unitaire = $request->input('prix-'.$code);
                if ($prix_achat != null && $prix_achat != 0) $m_mouvement->prix_unitaire = ($prix_achat/$m_mouvement->entree);
                $m_mouvement->id_emplacement = $request->input('emplacement-'.$code);
                $m_mouvement->date_mouvement = $date;
                $m_mouvement->id_raison = 10;
                $m_mouvement->is_validate = 0;

                $m_mouvement->save();
            }
        }
        return back()->with('success', 'Entrées validées');
    }

    public function createPageEntreeNonConsommable(Request $request)
    {
        $data['produits'] = V_Produit::where('type_categorie', 'Non_consommable')->orderBy('nom')->get();
        $data['emplacements'] = V_Emplacement::where('type_categorie', 'Non_consommable')
            ->orderBy('ordre')->orderBy('emplacement')->get();
        $data['produit_notif'] = $request->input('produit');
        return view('entree/entree-non-consommable')->with($data);
    }
    public function createPageEntreeIngredient(Request $request)
    {
        $data['produits'] = V_Produit::where('type_categorie', 'Ingredient')->orderBy('nom')->get();
        $data['emplacements'] = V_Emplacement::where('type_categorie', 'Ingredient')
            ->orderBy('emplacement')->get();
        $data['produit_notif'] = $request->input('produit');
        return view('entree/entree-ingredient')->with($data);
    }
    public function createPageEntreeProduit(Request $request)
    {
        $data['produits'] = V_Produit::where('type_categorie', 'Produit')->where('est_stockable', 1)->orderBy('nom')->get();
        $data['emplacements'] = V_Emplacement::where('type_categorie', 'Produit')
            ->orderBy('emplacement')->get();
        $data['produit_notif'] = $request->input('produit');
        return view('entree/entree-produit')->with($data);
    }

}
