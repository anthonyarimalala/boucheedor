<?php

namespace App\Exports;

use App\Models\views\V_Produit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProduitsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return V_Produit::all();
        $produits = V_Produit::select('code', 'nom', 'description', 'categorie','unite', 'emplacement' ,'seuil_reapprovisionnement' ,'transformation_locale','est_stockable','duree_limite', 'type_categorie')
            ->orderBy('type_categorie')
            ->get();
        foreach ($produits as $produit) {
            $produit->transformation_locale = $this->modifyBoolean($produit->transformation_locale);
            $produit->est_stockable = $this->modifyBoolean($produit->est_stockable);
        }
        return $produits;
    }
    public function modifyBoolean($nombre){
        if ($nombre == 1)
            return 'oui';
        else
            return 'non';
    }
    public function headings(): array
    {
        return [
            'code',
            'nom',
            'description',
            'categorie',
            'unite',
            'emplacement_par_defaut',
            'seuil_d_approvisionnement',
            'transformation_locale',
            'stockable',
            'jours_limite_dans_le_stock',
            'type',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Appliquer le style en gras sur la première ligne (les en-têtes)
        return [
            1  => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

}
