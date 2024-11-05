<?php

namespace App\Http\Controllers\Inventaire\Detail;

use App\Http\Controllers\Controller;
use App\Models\views\V_MouvementInventaireDiagrammeProduitIngredient;
use Illuminate\Http\Request;

class DetailProduitIngredientController extends Controller
{
    //
    public function showProduitIngredientDetail(Request $request, $code_produit)
    {

        // http://127.0.0.1:8000/inventaire/detail-ingredient/I0004
        // http://127.0.0.1:8000/inventaire/detail-ingredient/I0004/mouvement-produit?date_debut=2024-11-04&date_fin=2024-11-05
        // http://127.0.0.1:8000/inventaire/detail/{code_produit}/mouvement-produit

        $data['details'] = V_MouvementInventaireDiagrammeProduitIngredient::where('ingredient_code_produit', $code_produit)
            ->where('date', '>=', $request->input('date_debut'))
            ->where('date', '<=', $request->input('date_fin'))
            ->get();
        return view('inventaire/detail/produit/detail-produit-ingredient-inventaire')->with($data);

    }
}
