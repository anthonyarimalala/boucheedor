<?php

namespace App\Http\Controllers\Export;

use App\Exports\ProduitsExport;
use App\Http\Controllers\Controller;
use App\Models\exportExcel\StockExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //
    public function exportProduits()
    {
        return Excel::download(new ProduitsExport, 'donnees-produits.xlsx');
    }
}
