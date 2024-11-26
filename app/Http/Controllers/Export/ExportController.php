<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\exportExcel\StockExport;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    //
    public function exportExcel()
    {
        $export = new StockExport();
        return $export->exportExcel();
    }
}
