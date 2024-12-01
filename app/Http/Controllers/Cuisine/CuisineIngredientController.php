<?php

namespace App\Http\Controllers\Cuisine;

use App\Http\Controllers\Controller;
use App\Models\cuisine\D_CuisineIngredient;
use App\Models\Mouvement;
use App\Models\User;
use App\Models\views\V_CuisineIngredient;
use App\Models\views\V_CuisineSortieNonConfirme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\views\V_Mouvement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CuisineIngredientController extends Controller
{
    //

    public function confirmerSortie(Request $request){
        $id_mouvement = $request->input('id_mouvement');
        $m_mouvement = Mouvement::find($id_mouvement);
        $numero = $request->input('numero');
        $sortie = $request->input('sortie');

        if ($numero == null || $numero =='')
            DB::update('UPDATE d_cuisine_ingredients SET id_user_confirmation = ? WHERE id_mouvement = ?', [\Illuminate\Support\Facades\Auth::user()->id, $id_mouvement]);
        elseif ($numero != null && $numero != '')
            DB::update('UPDATE d_cuisine_ingredients SET id_user_confirmation = ? WHERE id_mouvement = ? AND numero = ?', [\Illuminate\Support\Facades\Auth::user()->id, $id_mouvement, $numero]);

        $m_mouv = new Mouvement();
        $m_mouv->code_produit = $m_mouvement->code_produit;
        $m_mouv->id_emplacement = $m_mouvement->id_emplacement;
        $m_mouv->sortie = $sortie;
        $m_mouv->reference_sortie = $id_mouvement;
        $m_mouv->id_raison = 22;
        $m_mouv->prix_unitaire = $m_mouvement->prix_unitaire;
        $m_mouv->date_mouvement = Carbon::now();

        $m_mouv->save();
        return back();

    }

    // Ty mbola amboarina fa tsy ampy
    public function showConfirmationSortie(Request $request){
        $data['v_non_confirmes'] = V_CuisineSortieNonConfirme::where('id_user', '!=', \Illuminate\Support\Facades\Auth::user()->id)->get();
        return view('cuisine/confirmation')->with($data);
    }

    public function sortieNonConfirme(Request $request)
    {
        $id_mouvement = $request->input('id_mouvement');
        $quantite = $request->input('sortie');
        $nom_produit = $request->input('nom_produit');
        $unite = $request->input('unite');

        print('id_mouvement: '.$id_mouvement.'<br>');
        print('sortie: '.$quantite.'<br>');

        $ci = new D_CuisineIngredient();
        $ci->id_mouvement = $id_mouvement;
        $ci->nom_produit = $nom_produit;
        $ci->sortie = $quantite;
        $ci->unite = $unite;
        $ci->id_user = \Illuminate\Support\Facades\Auth::user()->id;

        $ci->save();
        return back()->with('success', 'Sortie réussi.');
    }
    public function sortiePartNonConfirme(Request $request){
        $id_mouvement = $request->input('id_mouvement');
        $numeros = $request->input('numeros');
        $nom_produit = $request->input('nom_produit');
        $unite = $request->input('unite');

        print('id_mouvement = '.$id_mouvement. '<br>');
        print_r($numeros);

        if ($numeros != null){
            foreach ($numeros as $numero => $quantite){
                if ($quantite==null || $quantite=='') continue;
                $ci = new D_CuisineIngredient();
                $ci->id_mouvement =$id_mouvement;
                $ci->nom_produit = $nom_produit;
                $ci->numero = $numero;
                $ci->sortie = $quantite;
                $ci->unite = $unite;
                $ci->id_user = \Illuminate\Support\Facades\Auth::user()->id;
                $ci->save();
            }
        }
        return back()->with('success', 'Sortie réussi.');

    }
    public function diviserIngredient(Request $request)
    {
        //return back();

        $id_mouvement = $request->input('id_mouvement');
        $m_vm = V_Mouvement::find($id_mouvement);
        $nbr_divise = $request->input('nbr_divise');
        $unite = $request->input('unite');

        $unite_gramme = $request->input('unite_en_gramme');
        $convertiseur = 1;
        if ($unite_gramme != '' || $unite_gramme != null){
            $convertiseur = 1000;
        }

      //Validation
        // Calculena ilay total
        $total = 0;
        for ($i=1; $i<=$nbr_divise; $i++) {
            $total = $total + ($request->input('part-'.$i) / $convertiseur);
        }
        if ($total != $m_vm->reste_en_stock) {
            return back()->withErrors(['error'=> 'Différence entre le stock et la somme des parts. stock='.$m_vm->reste_en_stock.', somme='.$total.'.']);
        }
        for($i=1; $i<=$nbr_divise; $i++){
            $part = ($request->input('part-'.$i) / $convertiseur);
            $m_ci = new D_CuisineIngredient();
            $m_ci->id_mouvement = $request->id_mouvement;
            $m_ci->nom_produit = $m_vm->nom;
            $m_ci->numero = $i;
            $m_ci->entree = $part;
            $m_ci->unite = $unite;
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
        $data['parts'] = V_CuisineIngredient::where('id_mouvement', $id_mouvement)->orderBy('numero')->get();
        $data['v_cuisine_sortie_non_confirmes'] = V_CuisineSortieNonConfirme::where('id_user', \Illuminate\Support\Facades\Auth::user()->id)
            ->whereNotNull('som_sortie')
            ->get();

        // si l'ingrédient est divisé
        if (sizeof($data['parts'])>0)
            if ($data['parts'][0]->numero!=null)
                return view('cuisine/gestion/gestion-ingredient-part')->with($data);
        //print(sizeof($data['parts']));
        return view('cuisine/gestion/gestion-ingredient')->with($data);
    }
}
