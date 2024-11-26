<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Emplacement;
use App\Models\produits\Ingredient;
use App\Models\produits\Produit;
use App\Models\table\Unite;
use App\Models\views\V_Emplacement;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    //


    public function createProduit(Request $request){
        $validated = $request->validate([
            'nom' => 'required|string|min:3',
            'description' => '',
            'id_categorie' => 'required',
            'unite' => 'required',
            'seuil_reapprovisionnement' => 'required|numeric',
            'transformation_locale' => 'required',
            'duree_limite' => 'required',
        ]);

        if ($request->input('transformation_locale') === 1){
            $request->validate([
                'est_stockable' => 'required',
            ]);
        }
        $produit = new Produit();
        $produit->code = Produit::generateCode("P", 4, 'code_produit_seq');
        $produit->nom = $request->input('nom');
        $produit->description = $request->input('description');
        $produit->id_categorie = $request->input('id_categorie');
        $produit->id_emplacement_defaut = $request->input('id_emplacement');
        $produit->unite = $request->input('unite');
        $produit->seuil_reapprovisionnement = $request->input('seuil_reapprovisionnement');
        $produit->duree_limite = $request->input('duree_limite');
        $produit->transformation_locale = $request->input('transformation_locale');
        $produit->est_stockable = $request->input('est_stockable');
        if ($produit->transformation_locale == 0) $produit->est_stockable = 1;


        $produit->save();
        return back()->with('success', 'Produit "'.$produit->nom.'" ajoutée avec succès!');
    }

    public function createPageProduit(){
        $data['categories'] = Categorie::where('type_categorie', 'Produit')->orderBy('is_default', 'desc')->get();
        $data['emplacements'] = V_Emplacement::where('type_categorie', 'Produit')->get();
        $data['unites'] = Unite::orderBy('unite')->get();
        return view('nouveau/produit')->with($data);
    }
}
