<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Emplacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmplacementController extends Controller
{
    //
    public function deleteEmplacement(Request $request){
        $id_emplacement = $request->input('id_emplacement');
        $emplacement = $request->input('emplacement');
        DB::update('UPDATE emplacements SET is_deleted = 1 WHERE id=?', [$id_emplacement]);
        return back()->with('success', 'Emplacement '.$emplacement.' supprimée avec succès!');
    }
    public function createEmplacement(Request $request){
        $validated = $request->validate([
            'emplacement' => 'required|string|min:3',
        ]);
        $type_categories = $request->get('type_categories');

        $m_emplacement = Emplacement::create($validated);
        foreach ($type_categories as $type_category)  {
            DB::insert("INSERT INTO l_emplacement_type_categories(id_emplacement, type_categorie) VALUES (?, ?)", [$m_emplacement->id, $type_category]);
        }
        return back()->with('success', 'Emplacement "'.$m_emplacement->emplacement.'" ajoutée avec succès!');
    }

    public function createPageEmplacement(){
        return view('nouveau/emplacement');
    }
}
