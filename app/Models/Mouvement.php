<?php

namespace App\Models;

use App\Models\views\V_Mouvement;
use App\Models\views\V_Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

class Mouvement extends Model
{
    use HasFactory;
    protected $table = 'mouvements';

    public function stockVerification($code_produit, $id_emplacement, $quantite){
        $m_v_stock = V_Stock::where('code_produit', $code_produit)->where('id_emplacement', $id_emplacement)->first();
        if ($quantite > $m_v_stock->reste) throw new ValidationException('Le stock de <strong>'.$m_v_stock->nom.' ('.$m_v_stock->emplacement.')</strong> ne dépasse pas <strong>'.$m_v_stock->reste.'</strong>');
        return 0;
    }


    // $orderBy: asc pour fifo, desc pour lifo
    // $id_raison: 10 entree(misy karazany), 20 sortie(misy karazany)
    public static function mouvementSortie($code_produit, $id_emplacement, $quantite, $date, $orderBy, $id_raison){
        $v_m_mouvements = V_Mouvement::where('code_produit', $code_produit)
            ->where('id_emplacement', $id_emplacement)
            ->where('reste_en_stock', '!=', 0)
            ->orderBy('date_mouvement', $orderBy)
            ->limit(1)
            ->get();

        foreach($v_m_mouvements as $m){

            $quantite_restante = $m->reste_en_stock - $quantite;
            $m_mouvement = new Mouvement();
            $m_mouvement->code_produit = $m->code_produit;
            $m_mouvement->reference_sortie = $m->id;
            $m_mouvement->prix_unitaire = $m->prix_unitaire;
            $m_mouvement->id_emplacement = $m->id_emplacement;
            $m_mouvement->date_mouvement = $date;
            $m_mouvement->id_raison = $id_raison;


            if ($quantite_restante < 0){
                $m_mouvement->sortie = $m->reste_en_stock; // Ilay zavatra rehetra ao lasa sortie
                $quantite = abs($quantite_restante); // Averina positif ilay izy
                $m_mouvement->save();
            }elseif ($quantite_restante > 0){
                $m_mouvement->sortie = $quantite;
                $m_mouvement->save();
                break; // efa tsisy stock tokony hivoaka intsony
            }
            else if ($quantite_restante == 0){
                $m_mouvement->sortie = $m->reste_en_stock;
                $m_mouvement->save();
                break;
            }

        }
    }

    public function mouvementSorties($v_m_mouvements, $quantite, $date, $id_raison){


        foreach($v_m_mouvements as $m){

            $quantite_restante = $m->reste_en_stock - $quantite;
            $m_mouvement = new Mouvement();
            $m_mouvement->code_produit = $m->code_produit;
            $m_mouvement->reference_sortie = $m->id;
            $m_mouvement->prix_unitaire = $m->prix_unitaire;
            $m_mouvement->id_emplacement = $m->id_emplacement;
            $m_mouvement->date_mouvement = $date;
            $m_mouvement->id_raison = $id_raison;

            if ($quantite_restante < 0){
                $m_mouvement->sortie = $m->reste_en_stock; // Ilay zavatra rehetra ao lasa sortie
                $quantite = abs($quantite_restante); // Averina positif ilay izy
                $m_mouvement->save();
            }elseif ($quantite_restante > 0){
                $m_mouvement->sortie = $quantite;
                $m_mouvement->save();
                break; // efa tsisy stock tokony hivoaka intsony
            }
            else if ($quantite_restante == 0){
                $m_mouvement->sortie = $m->reste_en_stock;
                $m_mouvement->save();
                break;
            }
        }
    }
}
