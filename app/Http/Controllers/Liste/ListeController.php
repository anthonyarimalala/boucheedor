<?php

namespace App\Http\Controllers\Liste;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\produits\Produit;
use App\Models\views\V_Produit;
use Illuminate\Http\Request;

class ListeController extends Controller
{
    //

    public function showListeCategories(){
        $data['categories'] = Categorie::all();
        return view('liste/liste-categorie')->with($data);
    }
    public function showListeProduits(){
        $data['v_produits'] = V_Produit::where('is_deleted', 0)->get();
        return view('liste/liste-produit')->with($data);
    }


}
