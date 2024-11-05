<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\produits\Produit;
use App\Models\table\L_ProduitIngredient;
use App\Models\table\Unite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class L_ProduitIngredientController extends Controller
{
    //
    public function updateL_ProduitIngredient(Request $request, $code_produit){
        $ingredients = $request->input('ingredients');
        if($ingredients == null) return back()->withErrors('no-ingredient','Veuillez sélectionner des ingrédients.');
        DB::delete('DELETE FROM l_produit_ingredients WHERE code_produit = ?',[$code_produit]);

        foreach ($ingredients as $ingredient){

            $ingredient_code_produit = $ingredient;
            $quantite = $request->input('quantite-'.$ingredient);

            $m_l_produit_ingredient = new L_ProduitIngredient();
            $m_l_produit_ingredient->code_produit = $code_produit;
            $m_l_produit_ingredient->ingredient_code_produit = $ingredient_code_produit;
            $m_l_produit_ingredient->quantite = $quantite;

            $m_l_produit_ingredient->save();

            $quantite = $request->input('quantite-'.$ingredient);
            print('quantite -> '. $quantite);
        }
        print_r($ingredients);
        return back()->with('success', 'Ingredient mis à jour!');
    }

    public function updatePageL_ProduitIngredient($code_produit){

        $data['produit'] = Produit::where('code', $code_produit)->first();
        if ($data['produit'] == null) return redirect('modifier-recette/liste-produit');
        if ($data['produit']->transformation_locale != 1) return back();
        $data['produit_ingredients'] = L_ProduitIngredient::where('code_produit', $code_produit)->get();
        $data['m_l_produit_ingredient'] = new L_ProduitIngredient();

        $data['ingredients'] = Produit::where('transformation_locale', 0)->get();

        // print($data['produit_ingredients']);
        return view('modification/recette/affecter-ingredient')->with($data);
    }
    public function showListeProduits(){
        $data['transformation_locales'] = Produit::where('transformation_locale', 1)->orderBy('nom', 'asc')->get();
        return view('modification/recette/liste-produit')->with($data);
    }
}
