<?php

namespace App\Http\Controllers\Inventaire;

use App\Http\Controllers\Controller;
use App\Models\views\V_Mouvement;
use Illuminate\Http\Request;

class InventaireController extends Controller
{
    //
    public function showInventaireTous(){
        $data['v_mouvements'] = V_Mouvement::where('reste_en_stock','!=',0)
            ->where('est_stockable', 1)
            ->get();
        $m_v_mouvement = new V_Mouvement();
        $data['m_v_mouvement'] = $m_v_mouvement;
        return view('inventaire/tous')->with($data);
    }
    public function showInventaireProduit()
    {
        if(\Illuminate\Support\Facades\Auth::user()->role == 'admin'){
            $data['v_mouvements'] = V_Mouvement::where('type_categorie', 'Produit')
            ->where('reste_en_stock','!=',0)
            ->where('est_stockable', 1)
            ->get();
        }else if(\Illuminate\Support\Facades\Auth::user()->role == 'cuisinier'){
            $data['v_mouvements'] = V_Mouvement::where('type_categorie', 'Produit')
            ->where('reste_en_stock','!=',0)
            ->where('est_stockable', 1)
            ->where('transformation_locale', 1)
            ->get();
        }


        $m_v_mouvement = new V_Mouvement();
        $data['m_v_mouvement'] = $m_v_mouvement;
        return view('inventaire/produit')->with($data);
    }
    public function showInventaireIngredient()
    {
        $data['v_mouvements'] = V_Mouvement::where('type_categorie', 'Ingredient')->where('reste_en_stock','!=',0)
            ->where('emplacement', '!=', '')
            ->get();
        $m_v_mouvement = new V_Mouvement();
        $data['m_v_mouvement'] = $m_v_mouvement;
        return view('inventaire/ingredient')->with($data);
    }
    public function showInventaireNonConsommable()
    {
        $data['v_mouvements'] = V_Mouvement::where('type_categorie', 'Non_consommable')->where('reste_en_stock','!=',0)
            ->where('emplacement', '!=', '')
            ->get();
        $m_v_mouvement = new V_Mouvement();
        $data['m_v_mouvement'] = $m_v_mouvement;
        return view('inventaire/non-consommable')->with($data);
    }


}
