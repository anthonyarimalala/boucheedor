<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\FicheProduitsImport;
use App\Imports\ProduitsImport;
use App\Models\import\ImportFicheProduit;
use App\Models\import\ImportProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //

    public function importFicheProduit(Request $request)
    {
        $request->validate([
           'file' => 'required|mimes:xlsx,csv',
        ]);
        DB::delete("DELETE FROM import_fiche_produits");
        Excel::import(new FicheProduitsImport, $request->file('file'));
        $importFicheProduit = new ImportFicheProduit();
        $importFicheProduit->insert_l_produit_ingredients();
        return redirect()->back()->with('success', ' Fiche Produits importés avec succès! ');
    }
    public function importProduit(Request $request){
        /*
        $imp = new ImportProduit();
        $imp->insertProduit();
        */
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        DB::delete("DELETE FROM import_produits");
        Excel::import(new ProduitsImport, $request->file('file'));
        // mise à jour des tableaux
        $imp = new ImportProduit();
        $imp->updateDataTableCategorie();
        $imp->updateDataTableUnite();
        $imp->updateDataTableEmplacement();
        $imp->insertProduit();
        return redirect()->back()->with('success', 'Produits importés avec succès! ');

    }
    public function showImportPage(){
        return view('import/import');
    }
}
