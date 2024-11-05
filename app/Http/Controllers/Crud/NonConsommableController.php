<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\produits\NonConsommable;
use App\Models\produits\Produit;
use App\Models\table\Unite;
use Illuminate\Http\Request;

class NonConsommableController extends Controller
{
    //
    public function createNonConsommable(Request $request){
        $validated = $request->validate([
            'nom' => 'required|string|min:3',
            'description' => '',
            'id_categorie' => 'required',
            'unite' => 'required',
            'seuil_reapprovisionnement' => 'required|numeric',
        ]);
        $m_non_consommable = new NonConsommable();
        $m_non_consommable->code = Produit::generateCode("NC", 4, "code_non_consommable_seq");
        $m_non_consommable->nom = $request->input('nom');
        $m_non_consommable->description = $request->input('description');
        $m_non_consommable->id_categorie = $request->input('id_categorie');
        $m_non_consommable->unite = $request->input('unite');
        $m_non_consommable->seuil_reapprovisionnement = $request->input('seuil_reapprovisionnement');
        $m_non_consommable->transformation_locale = 0;
        $m_non_consommable->est_stockable = 1;


        $m_non_consommable->save();
        return back()->with('success', 'Non consommable "'.$m_non_consommable->nom.'" ajouté avec succès!');


    }

    public function createPageNonConsommable(){
        $data['categories'] = Categorie::where('type_categorie', 'Non_consommable')->orderBy('is_default', 'desc')->get();
        $data['unites'] = Unite::orderBy('unite')->get();
        return view('nouveau/non-consommable')->with($data);
    }
}
