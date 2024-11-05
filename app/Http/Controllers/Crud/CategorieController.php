<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    //
    public function createCategorie(Request $request){
        $validated = $request->validate([
            'categorie' => 'required|string|min:3',
            'description' => '',
            'type_categorie' => 'required',
        ]);
        print_r($validated);
        $m_categorie = Categorie::create($validated);

        return back()->with('success', 'Catégorie '.$m_categorie->categorie.' ajoutée avec succès!');
    }
    public function createPageCategorie(){
        return view('nouveau/categorie');
    }
}
