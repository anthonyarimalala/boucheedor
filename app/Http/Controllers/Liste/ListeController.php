<?php

namespace App\Http\Controllers\Liste;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Emplacement;
use App\Models\produits\Produit;
use App\Models\table\Unite;
use App\Models\views\V_Emplacement;
use App\Models\views\V_Produit;
use Illuminate\Http\Request;

class ListeController extends Controller
{
    //

    public function showListeEmplacements(){
        $data['emplacements'] = Emplacement::where('is_deleted', '!=', 1)->get();
        $data['m_emp'] = new Emplacement();
        //print($data['emplacements']);
        return view('liste/liste-emplacement')->with($data);
    }


    public function showProduitDetails(Request $request){
        $code = $request->input('code');
        $v_produit = V_Produit::where('code', $code)->first();
        $categories = Categorie::where('type_categorie', $v_produit->type_categorie)->get();
        $unites = Unite::all();
        $emplacements = V_Emplacement::where('type_categorie', $v_produit->type_categorie)->get();

        print($emplacements);
    }
    public function getProduitDetails($code)
    {
        try {
            $v_produit = V_Produit::where('code', $code)->first();

            if (!$v_produit) {
                \Log::error("Produit avec code {$code} non trouvé.");
                return response()->json(['error' => 'Produit non trouvé'], 404);
            }

            $categories = Categorie::where('type_categorie', $v_produit->type_categorie)->get();
            $unites = Unite::all();
            $emplacements = V_Emplacement::where('type_categorie', $v_produit->type_categorie)->get();

            return response()->json([
                'v_produit' => $v_produit,
                'categories' => $categories,
                'unites' => $unites,
                'emplacements' => $emplacements,
            ]);
        } catch (\Exception $e) {
            \Log::error("Erreur lors de la récupération des détails du produit : " . $e->getMessage());
            return response()->json(['error' => 'Erreur interne au serveur'], 500);
        }
    }

    public function showListeCategories(){
        $data['categories'] = Categorie::where('is_deleted', '!=', 1)->get();
        return view('liste/liste-categorie')->with($data);
    }
    public function showListeProduits(){
        $data['v_produits'] = V_Produit::where('is_deleted', 0)->get();
        $data['categories'] = Categorie::all();

        // print($data['categories']);
        // print($data['v_produits']);
        return view('liste/liste-produit')->with($data);
    }


}
