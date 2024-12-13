<?php

namespace App\Models\import;

use App\Models\produits\Ingredient;
use App\Models\produits\Produit;
use App\Models\table\L_ProduitIngredient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImportFicheProduit extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_p',
        'produit',
        'code_i',
        'ingredient',
        'quantite',
        'unite',
    ];
    public $timestamps = false;

    public function insert_l_produit_ingredients()
    {
        $importFicheProduits = DB::select('SELECT * FROM import_fiche_produits');
        foreach ($importFicheProduits as $importFicheProduit){
            // créer ou obtenir la premiere entrée
            $l_produit_ingredient = L_ProduitIngredient::firstOrNew([
                'code_produit' => $this->insertAndGetIdProduit($importFicheProduit->code_p, $importFicheProduit->produit),
                'ingredient_code_produit' => $this->insertAndGetIdIngredient($importFicheProduit->code_i, $importFicheProduit->ingredient, $importFicheProduit->unite),
            ]);
            if (!$l_produit_ingredient->exists) {
                $l_produit_ingredient->quantite = $importFicheProduit->quantite;
                $l_produit_ingredient->save();
            }
        }
        return back()->with('success', 'Fiche produit créée avec succès!');
    }
    public function insertAndGetIdProduit($code_p, $nom_produit)
    {
        $produit = Produit::where('code', $code_p)->first();
        if (!$produit){
            $produit = Produit::where('nom', $nom_produit)->first();
        }
        if (!$produit){
            $max_P = DB::select("SELECT COALESCE(MAX(SUBSTRING(code FROM '[0-9]+')::INTEGER), 0) AS max_code FROM produits WHERE code LIKE 'P%'")[0]->max_code;
            // Chercher le premier id_categorie du type produit pour mettre en default
            $categ_produit_IDs = DB::select("SELECT id FROM categories WHERE type_categorie='Produit' LIMIT 1");
            if (!$categ_produit_IDs) return back()->withErrors(['error'=>'Ajouter en premier une categorie pour les produits']);
            $first_categ_produit_ID = $categ_produit_IDs[0]->id;

            // Chercher le premier id_emplacement du type ingrédient pour mettre en default
            $empl_produit_IDs = DB::select("SELECT id_emplacement FROM l_emplacement_type_categories WHERE type_categorie='Produit' LIMIT 1");
            if (!$empl_produit_IDs) return back()->withErrors(['error'=>'Ajouter en premier un emplacement pour les produits']);
            $first_empl_produit_ID = $empl_produit_IDs[0]->id_emplacement;

            $produit = new Produit();
            $produit->code = Produit::generateCodeNonSeq("P", 4, $max_P+1);
            $produit->nom = $nom_produit;
            $produit->id_categorie = $first_categ_produit_ID;
            $produit->unite = 'unité';
            $produit->id_emplacement_defaut = $first_empl_produit_ID;
            $produit->seuil_reapprovisionnement = 0;
            $produit->transformation_locale = 0;
            $produit->est_stockable = 1;
            $produit->duree_limite = 7;
        }
        $produit->save();
        return $produit->code;
    }

    public function insertAndGetIdIngredient($code_i, $nom_ingredient, $unite)
    {
        $ingredient = Ingredient::where('code', $code_i)->first();
        if (!$ingredient){
            $ingredient = Ingredient::where('nom', $nom_ingredient)->first();
        }
        if (!$ingredient){
            $max_I = DB::select("SELECT COALESCE(MAX(SUBSTRING(code FROM '[0-9]+')::INTEGER), 0) AS max_code FROM produits WHERE code LIKE 'I%'")[0]->max_code;
            if ($unite == null) $unite = 'kg';
            // Chercher le premier id_categorie du type ingrédient pour mettre en default
            $categ_ingredient_IDs = DB::select("SELECT id FROM categories WHERE type_categorie='Ingredient' LIMIT 1");
            if (!$categ_ingredient_IDs) return back()->withErrors(['error'=>'Ajouter en premier une categorie pour les ingrédients']);
            $first_categ_ingredient_ID = $categ_ingredient_IDs[0]->id;

            // Chercher le premier id_emplacement du type ingrédient pour mettre en default
            $empl_ingredient_IDs = DB::select("SELECT id_emplacement FROM l_emplacement_type_categories WHERE type_categorie='Ingredient' LIMIT 1");
            if (!$empl_ingredient_IDs) return back()->withErrors(['error'=>'Ajouter en premier un emplacement pour les ingrédients']);
            $first_empl_ingredient_ID = $empl_ingredient_IDs[0]->id_emplacement;

            $ingredient = new Ingredient();
            $ingredient->code = Produit::generateCodeNonSeq("I", 4, $max_I+1);
            $ingredient->nom = $nom_ingredient;
            $ingredient->id_categorie = $first_categ_ingredient_ID;
            $ingredient->unite = $unite;
            $ingredient->id_emplacement_defaut = $first_empl_ingredient_ID;
            $ingredient->seuil_reapprovisionnement = 0;
            $ingredient->transformation_locale = 0;
            $ingredient->est_stockable = 1;
            $ingredient->duree_limite = 7;
        }
        $ingredient->save();
        return $ingredient->code;
    }
}
