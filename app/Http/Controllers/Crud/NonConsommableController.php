<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\produits\NonConsommable;
use App\Models\produits\Produit;
use App\Models\table\Unite;
use App\Models\views\V_Emplacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $max_NC = DB::select("SELECT COALESCE(MAX(SUBSTRING(code FROM '[0-9]+')::INTEGER), 0) AS max_code FROM produits WHERE code LIKE 'NC%'")[0]->max_code;
        $m_non_consommable = new NonConsommable();
        $m_non_consommable->code = Produit::generateCodeNonSeq("NC", 4, $max_NC+1) ;
        $m_non_consommable->nom = $request->input('nom');
        $m_non_consommable->description = $request->input('description');
        $m_non_consommable->id_categorie = $request->input('id_categorie');
        $m_non_consommable->id_emplacement_defaut = $request->input('id_emplacement');
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
        $data['emplacements'] = V_Emplacement::where('type_categorie', 'Non_consommable')->get();
        return view('nouveau/non-consommable')->with($data);
    }
}
