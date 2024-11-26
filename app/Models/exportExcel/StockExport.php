<?php

namespace App\Models\exportExcel;

use App\Models\views\V_Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use OpenSpout\Common\Entity\Style\Style;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\views\V_Produit;

class StockExport extends Model
{
    use HasFactory;


    public function exportExcel()
    {
        $data = [
            ['Nom', 'Age'],
            ['Alice', 4],
            ['Bob', 3],
            ['Jean', 7],
        ];

        Excel::create('Fichier_Test', function ($excel) use($data) {
            $excel->sheet('Feuille 1', function ($sheet) use($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
            });
        })->export('xls');
    }

    public function eexportExcel(){
        $stocks = DB::select('SELECT
                        code_produit,
                        nom,
                        unite,
                        SUM(reste_en_stock) AS reste_en_stock,
                        seuil_reapprovisionnement
                    FROM v_mouvements
                    GROUP BY code_produit, nom, unite, seuil_reapprovisionnement');
        $headerStyle = (new Style())
            ->setFontBold()
            ->setFontSize(12);

        $writer = SimpleExcelWriter::streamDownload('your-export.xlsx')
            ->noHeaderRow();
        $writer->addRow(['Code', 'Article', 'Unité', 'Quantité en Stock', 'Seuil minimale', 'Alerte ?' ], $headerStyle);
        foreach ($stocks as $stock){
            $alerte = 'Stock OK';
            if ($stock->reste_en_stock < $stock->seuil_reapprovisionnement) $alerte = 'Alerte!';
            $writer->addRow([$stock->code_produit, $stock->nom, $stock->unite, $stock->reste_en_stock, $stock->seuil_reapprovisionnement, $alerte]);
        }
        $writer->toBrowser();
    }


}
