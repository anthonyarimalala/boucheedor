<?php

namespace App\Imports;

use App\Models\import\ImportFicheProduit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FicheProduitsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ImportFicheProduit([
            //
            'code_p' => $row['code_p'],
            'produit' => $row['produit'],
            'code_i' => $row['code_i'],
            'ingredient' => $row['ingredient'],
            'quantite' => $row['quantite'],
            'unite' => $row['unite'],
        ]);
    }
}
