<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\produits\Ingredient;
use App\Models\produits\NonConsommable;
use App\Models\produits\Produit;
use App\Models\table\Unite;
use App\Models\views\V_Emplacement;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    //
    public function createPageIngredient(){
        $data['categories'] = Categorie::where('type_categorie', 'Ingredient')->orderBy('is_default', 'desc')->get();
        $data['unites'] = Unite::orderBy('unite')->get();
        $data['emplacements'] = V_Emplacement::where('type_categorie', 'Ingredient')->get();
        return view('nouveau/ingredient')->with($data);
    }

    public function createIngredient(Request $request){
        $validated = $request->validate([
            'nom' => 'required|string|min:3',
            'description' => '',
            'id_categorie' => 'required',
            'unite' => 'required',
            'seuil_reapprovisionnement' => 'required|numeric',
        ]);
        $ingredient = new Ingredient();
        $ingredient->code = Produit::generateCode("I", 4, 'code_ingredient_seq');
        $ingredient->nom = $request->input('nom');
        $ingredient->description = $request->input('description');
        $ingredient->id_categorie = $request->input('id_categorie');
        $ingredient->unite = $request->input('unite');
        $ingredient->seuil_reapprovisionnement = $request->input('seuil_reapprovisionnement');
        $ingredient->id_emplacement_defaut = $request->input('id_emplacement');
        $ingredient->duree_limite = $request->input('duree_limite');
        $ingredient->transformation_locale = 0;
        $ingredient->est_stockable = 1;

        $ingredient->save();
        return back()->with('success', 'Ingredient "'.$ingredient->nom.'" ajoutée avec succès!');
    }
}
