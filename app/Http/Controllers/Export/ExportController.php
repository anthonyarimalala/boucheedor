<?php

namespace App\Http\Controllers\Export;

use App\Exports\ProduitsExport;
use App\Exports\RapportsExport;
use App\Http\Controllers\Controller;
use App\Models\exportExcel\StockExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //

    public function exportRapports()
    {
        // Nom du fichier à générer
        $fileName = 'rapports_stock_' . date('Y-m-d') . '.xlsx';

        // Appel de l'export et génération du fichier Excel
        return Excel::download(new RapportsExport, $fileName);
    }
    public function exportProduits()
    {
        $fileName = 'donnees-produit_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new ProduitsExport, $fileName);
    }
}
