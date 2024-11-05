<?php

namespace App\Models\class;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    public static function makeAlertRuptureNotification(){
        $m_v_mouvements =  DB::select('SELECT
                                                vm.code_produit,
                                                vm.nom,
                                                vm.type_categorie,
                                                SUM(reste_en_stock) AS reste_en_stock,
                                                vm.seuil_reapprovisionnement
                                            FROM v_mouvements vm
                                            GROUP BY vm.code_produit, vm.type_categorie, vm.nom, vm.seuil_reapprovisionnement');
        if ($m_v_mouvements != null){
            foreach ($m_v_mouvements as $v_mouvement){
                $lien = '';
                if ($v_mouvement->type_categorie == 'Produit') $lien = 'non-consommable';
                if ($v_mouvement->type_categorie == 'Ingredient') $lien = 'ingredient';
                if ($v_mouvement->type_categorie == 'Non_consommable') $lien = 'non-consommable';

                if ($v_mouvement->reste_en_stock == 0){
                    $notification = new Notification();
                    $notification->code_produit = $v_mouvement->code_produit;
                    $notification->titre = 'Rupture';
                    $notification->produit = $v_mouvement->nom;
                    $notification->couleur = 'red';
                    $notification->description = '"'.$v_mouvement->nom.'" en rupture de stock.';
                    $notification->lien = '/entree-'.$lien;
                    $notification->date_notification = Carbon::now();
                    $notification->save();
                }
            }
        }
    }
    public static function makeAlertNotification(){
        $m_v_mouvements =  DB::select('SELECT
                            vm.code_produit,
                            vm.nom,
                            vm.type_categorie,
                            vm.duree_limite,
                            SUM(reste_en_stock) AS reste_en_stock,
                            vm.seuil_reapprovisionnement,
                            (SELECT MIN(vm1.date_mouvement) FROM v_mouvements vm1 WHERE vm1.code_produit = vm.code_produit AND vm1.reste_en_stock != 0) AS date_mouvement
                        FROM v_mouvements vm
                        GROUP BY vm.code_produit, vm.type_categorie, vm.duree_limite, vm.nom, vm.seuil_reapprovisionnement');
        if ($m_v_mouvements != null){
            foreach ($m_v_mouvements as $v_mouvement){
                $lien = '';
                if ($v_mouvement->type_categorie == 'Produit') $lien = 'non-consommable';
                if ($v_mouvement->type_categorie == 'Ingredient') $lien = 'ingredient';
                if ($v_mouvement->type_categorie == 'Non_consommable') $lien = 'non-consommable';
                if ($v_mouvement->reste_en_stock == 0) continue;

                if ($v_mouvement->reste_en_stock < $v_mouvement->seuil_reapprovisionnement){
                    $notification = new Notification();
                    $notification->code_produit = $v_mouvement->code_produit;
                    $notification->titre = 'Stock faible';
                    $notification->produit = $v_mouvement->nom;
                    $notification->couleur = '#D35400';
                    $notification->description = 'Le stock de "'.$v_mouvement->nom.'" est au dessous du seuil de réapprovisionnement.';
                    $notification->lien = '/entree-'.$lien;
                    $notification->date_notification = Carbon::now();
                    $notification->save();
                }else if (Carbon::now() > Carbon::parse($v_mouvement->date_mouvement)->addDays($v_mouvement->duree_limite) && $v_mouvement->duree_limite!=null){
                    $notification = new Notification();
                    $notification->code_produit = $v_mouvement->code_produit;
                    $notification->titre = 'Date limite atteinte';
                    $notification->produit = $v_mouvement->nom;
                    $notification->couleur = '#2980B9';
                    $notification->description = 'Le stock de "'.$v_mouvement->nom.'" a atteint sa limite de date dans le stock.';
                    $notification->lien = '/sortie-'.$lien;
                    $notification->date_notification = Carbon::now();
                    $notification->save();
                }

            }
        }
    }
}
