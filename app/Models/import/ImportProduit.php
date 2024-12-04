<?php

namespace App\Models\import;

use App\Models\produits\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImportProduit extends Model
{
    use HasFactory;
    protected $table = 'import_produits';
    protected $fillable = [
      'code',
      'nom',
      'description',
      'categorie',
      'unite',
      'emplacement_par_defaut',
      'seuil_approvisionnement',
      'transformation_locale',
      'stockable',
      'jours_limite_dans_le_stock',
      'type'
    ];

    public $timestamps = false;


    public function insertProduit(){

        // récupérer les derniers chiffres des codes
        $max_I = DB::select("SELECT COALESCE(MAX(SUBSTRING(code FROM '[0-9]+')::INTEGER), 0) AS max_code FROM produits WHERE code LIKE 'I%'")[0]->max_code;
        $max_P = DB::select("SELECT COALESCE(MAX(SUBSTRING(code FROM '[0-9]+')::INTEGER), 0) AS max_code FROM produits WHERE code LIKE 'P%'")[0]->max_code;
        $max_NC = DB::select("SELECT COALESCE(MAX(SUBSTRING(code FROM '[0-9]+')::INTEGER), 0) AS max_code FROM produits WHERE code LIKE 'NC%'")[0]->max_code;

        $nombre = 0;
        $prefix = '';
        // récupérer tous les produits à importer
        $import_produits = DB::select('SELECT
            ip.code,
            ip.nom,
            ip.description,
            (SELECT c.id FROM categories c WHERE c.categorie = ip.categorie) AS id_categorie,
            ip.unite,
            (SELECT e.id FROM emplacements e WHERE e.emplacement = ip.emplacement_par_defaut) AS id_emplacement,
            ip.seuil_approvisionnement,
            ip.transformation_locale,
            ip.stockable,
            ip.jours_limite_dans_le_stock,
            ip.type
        FROM import_produits ip');

        foreach ($import_produits as $ip){
            if ($ip->code == null || $ip->code == ''){
                if ($ip->type == 'Produit'){
                    $max_P += 1;
                    $prefix = 'P';
                    $nombre = $max_P;
                }
                if ($ip->type == 'Ingredient'){
                    $max_I += 1;
                    $prefix = 'I';
                    $nombre = $max_I;
                }
                if ($ip->type == 'Non_consommable') {
                    $max_NC += 1;
                    $prefix = 'NC';
                    $nombre = $max_NC;
                }
                $produit = new Produit();
                  $produit->code = Produit::generateCodeNonSeq($prefix, 4, $nombre) ;
                  $produit->nom = $ip->nom ;
                  $produit->description = $ip->description;
                  $produit->id_categorie = $ip->id_categorie;
                  $produit->unite = $ip->unite;
                  $produit->id_emplacement_defaut = $ip->id_emplacement;
                  $produit->seuil_reapprovisionnement = $ip->seuil_approvisionnement;
                  $produit->transformation_locale = $ip->transformation_locale;
                  $produit->est_stockable = $ip->stockable;
                  $produit->duree_limite = $ip->jours_limite_dans_le_stock;
                  $produit->save();

            }else{
                $produit = Produit::where('code', $ip->code)->first();
                $produit->nom = $ip->nom ;
                $produit->description = $ip->description;
                $produit->id_categorie = $ip->id_categorie;
                $produit->unite = $ip->unite;
                $produit->id_emplacement_defaut = $ip->id_emplacement;
                $produit->seuil_reapprovisionnement = $ip->seuil_approvisionnement;
                $produit->transformation_locale = $ip->transformation_locale;
                $produit->est_stockable = $ip->stockable;
                $produit->duree_limite = $ip->jours_limite_dans_le_stock;
                $produit->save();
            }
        }

        /*
        $requette = 'SELECT
            ip.code,
            ip.nom,
            ip.description,
            (SELECT c.id FROM categories c WHERE c.categorie = ip.categorie),
            ip.unite,
            (SELECT e.id FROM emplacements e WHERE e.emplacement = ip.emplacement_par_defaut),
            ip.seuil_approvisionnement,
            ip.transformation_locale,
            ip.stockable,
            ip.jours_limite_dans_le_stock
        FROM import_produits ip';
        */
    }
    public function updateDataTableCategorie()
    {
        // Insérer les nouvelles catégories
        DB::INSERT('INSERT INTO categories(categorie, type_categorie, created_at)
                            SELECT
                                ip.categorie,
                                ip.type,
                                NOW()
                            FROM import_produits ip
                            WHERE ip.categorie NOT IN (SELECT c.categorie FROM categories c)
                            GROUP BY ip.categorie, ip.type');
    }
    public function updateDataTableUnite(){
        DB::insert('INSERT INTO unites(unite, signification)
                            SELECT
                                ip.unite,
                                ?
                            FROM import_produits ip
                            WHERE ip.unite NOT IN (SELECT u.unite FROM unites u)
                            GROUP BY ip.unite', ['non']);
    }
    public function updateDataTableEmplacement(){
        DB::insert('INSERT INTO emplacements(emplacement)
                            SELECT
                                    ip.emplacement_par_defaut
                                FROM import_produits ip
                                WHERE ip.emplacement_par_defaut NOT IN (SELECT e.emplacement FROM emplacements e)
                                GROUP BY ip.emplacement_par_defaut');

    }
}
