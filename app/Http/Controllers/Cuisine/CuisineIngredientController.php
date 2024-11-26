<?php

namespace App\Http\Controllers\Cuisine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\views\V_Mouvement;
use App\Models\cuisine\CuisineIngredient;

class CuisineIngredientController extends Controller
{
    //
    public function diviserIngredient(Request $request)
    {
        
        $id_mouvement = $request->input('id_mouvement');
        $m_vm = V_Mouvement::find($id_mouvement);
        $nbr_divise = $request->input('nbr_divise');

      //Validation
        // Calculena ilay total
        $total = 0;
        for ($i=1; $i<=$nbr_divise; $i++) { 
            $total = $total + $request->input('part-'.$i);
        }
        if ($total != $m_vm->reste_en_stock) {
            return back()->withErrors(['error'=> 'Différence entre le stock et la somme des parts. stock='.$m_vm->reste_en_stock.', somme='.$total.'.']);
        }
        for($i=1; $i<=$nbr_divise; $i++){
            $part = $request->input('part-'.$i);
            $m_ci = new CuisineIngredient();
            $m_ci->id_mouvement = $request->id_mouvement;
            $m_ci->numero = $i;
            $m_ci->entree = $part;
            $m_ci->id_user = \Illuminate\Support\Facades\Auth::user()->id;
            $m_ci->save();
        }
        return back()->with('success', 'Division réussi.');
    }

    public function showInventaireIngredient()
    {
        $data['v_mouvements'] = V_Mouvement::where('type_categorie', 'Ingredient')->where('reste_en_stock','!=',0)
            ->where('est_stockable', 1)
            ->get();
        $m_v_mouvement = new V_Mouvement();
        $data['m_v_mouvement'] = $m_v_mouvement;
        return view('cuisine/ingredient')->with($data);
    }

    public function showGestionIngredient($id_mouvement)
    {
        $data['v_mouvement'] = V_Mouvement::find($id_mouvement) ;
        return view('cuisine/gestion/gestion-ingredient')->with($data);
    }
}
