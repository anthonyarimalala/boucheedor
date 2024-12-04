<?php

namespace App\Imports;

use App\Models\import\ImportProduit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProduitsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $existingProduct = ImportProduit::where('nom', $row['nom'])->first();

        if ($existingProduct) {
            return null;
        }

        return new ImportProduit([
            //
            'code' => $row['code'],
            'nom' => $row['nom'],
            'description' => $row['description'] ?? null,
            'categorie' => $row['categorie'],
            'unite' => $row['unite'],
            'emplacement_par_defaut' => $row['emplacement_par_defaut'],
            'seuil_approvisionnement' => $row['seuil_d_approvisionnement'],
            'transformation_locale' => $this->modifyBoolean($row['transformation_locale']) ,
            'stockable' => $this->modifyBoolean($row['stockable']),
            'jours_limite_dans_le_stock' => $row['jours_limite_dans_le_stock'],
            'type' => $row['type'],
        ]);
    }
    private function modifyBoolean($oui)
    {
        if ($oui == 'oui') return 1;
        else if ($oui == 'non') return 0;
        return 0;
    }

    private function modifyCategory($category)
    {
        // Exemple de modification : ajouter un préfixe à la catégorie
        return 'Catégorie: ' . ucfirst($category);
    }
}
