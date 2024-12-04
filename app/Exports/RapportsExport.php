<?php

namespace App\Exports;

use App\Models\views\V_Mouvement;
use Maatwebsite\Excel\Concerns\FromCollection;

class RapportsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $rapports = V_Mouvement::where('reste_en_stock','!=',0)
            ->where('est_stockable', 1)
            ->get();
        return V_Mouvement::all();
    }
}
