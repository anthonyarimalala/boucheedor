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
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    //

    public function deleteProduit(Request $request){
        $code_produit = $request->input('code_produit');
        $produit = Produit::where('code', $code_produit)->first();
        if (!$produit) return back()->withErrors([
            'produit_non_touvé' => 'Le produit est introuvable',
        ]);
        $produit->is_deleted = 1;
        $produit->save();
        return back()->with('success', 'Produit supprimé avec succès');
    }
    public function updateProduit(Request $request){
        $code_produit = $request->input('code');
        $id_categorie = $request->input('id_categorie');
        $unite = $request->input('unite');
        $id_emplacement = $request->input('id_emplacement');
        $seuil_reapprovisionnement = $request->input('seuil_reapprovisionnement');
        $duree_limite = $request->input('duree_limite');

        DB::update('UPDATE produits SET id_categorie=?, unite=?, id_emplacement_defaut=?, seuil_reapprovisionnement=?, duree_limite=? WHERE code=?',
            [$id_categorie, $unite, $id_emplacement, $seuil_reapprovisionnement, $duree_limite, $code_produit]);

        return back()->with('success', 'Produit mis à jour avec succès!');
    }

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
