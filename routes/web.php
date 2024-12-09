<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', function() {
    return view('authentification/login');
});
Route::post('login', [ \App\Http\Controllers\Authentification\LoginController::class, 'login'])->name('login');
Route::post('logout', [\App\Http\Controllers\Authentification\LoginController::class, 'logout'])->name('logout');
Route::get('register', function() {
   return view('authentification/register');
});
Route::post('register', [ \App\Http\Controllers\Authentification\LoginController::class, 'register'])->name('register');


Route::middleware('auth')->group(function() {

    # section : crud de base
    Route::get('create-categorie', [\App\Http\Controllers\Crud\CategorieController::class, 'createPageCategorie']);
    Route::post('create-categorie', [\App\Http\Controllers\Crud\CategorieController::class, 'createCategorie'])->name('create-categorie');

    Route::get('create-emplacement', [\App\Http\Controllers\Crud\EmplacementController::class, 'createPageEmplacement']);
    Route::post('create-emplacement', [\App\Http\Controllers\Crud\EmplacementController::class, 'createEmplacement'])->name('create-emplacement');

    Route::get('create-ingredient', [\App\Http\Controllers\Crud\IngredientController::class, 'createPageIngredient']);
    Route::post('create-ingredient', [\App\Http\Controllers\Crud\IngredientController::class, 'createIngredient']);

    Route::get('create-produit', [\App\Http\Controllers\Crud\ProduitController::class, 'createPageProduit']);
    Route::post('create-produit', [\App\Http\Controllers\Crud\ProduitController::class, 'createProduit']);

    Route::get('create-non-consommable', [\App\Http\Controllers\Crud\NonConsommableController::class, 'createPageNonConsommable']);
    Route::post('create-non-consommable', [\App\Http\Controllers\Crud\NonConsommableController::class, 'createNonConsommable'])->name('create-non-consommable');

    Route::get('modifier-recette/liste-produit-transforme', [\App\Http\Controllers\Crud\L_ProduitIngredientController::class, 'showListeProduits']);
    Route::get('modifier-recette/{code_produit}/update-produit-ingredient', [\App\Http\Controllers\Crud\L_ProduitIngredientController::class, 'updatePageL_ProduitIngredient']);
    Route::post('modifier-recette/{code_produit}/update-produit-ingredient', [\App\Http\Controllers\Crud\L_ProduitIngredientController::class, 'updateL_ProduitIngredient'])->name('update-categorie');

    # section : liste
    Route::get('liste-produits', [\App\Http\Controllers\Liste\ListeController::class, 'showListeProduits']);
    Route::get('liste-categories', [\App\Http\Controllers\Liste\ListeController::class, 'showListeCategories']);

        # modifier
        Route::get('liste-produit/modifier/{code}', [\App\Http\Controllers\Liste\ListeController::class, 'getProduitDetails']);
        Route::post('update-produit', [\App\Http\Controllers\Crud\ProduitController::class, 'updateProduit']);
        Route::post('show-produit-detail', [\App\Http\Controllers\Liste\ListeController::class, 'showProduitDetails']);

        # supprimer
        Route::post('delete-produit', [\App\Http\Controllers\Crud\ProduitController::class, 'deleteProduit']);

    # section : historique
    Route::get('historique-mouvements', [\App\Http\Controllers\Historique\HistoriqueController::class, 'showHistorique']);

    # section : mouvements
    Route::get('entree-produit', [\App\Http\Controllers\Mouvement\EntreeController::class, 'createPageEntreeProduit']);
    Route::post('entree-produit', [\App\Http\Controllers\Mouvement\EntreeController::class, 'createEntreeProduit'])->name('entree-produit');
    Route::get('entree-ingredient', [\App\Http\Controllers\Mouvement\EntreeController::class, 'createPageEntreeIngredient']);
    Route::get('entree-non-consommable', [\App\Http\Controllers\Mouvement\EntreeController::class, 'createPageEntreeNonConsommable']);

    Route::get('sortie-non-consommable', [\App\Http\Controllers\Mouvement\SortieController::class, 'createPageSortieNonConsommable']);
    Route::get('sortie-ingredient', [\App\Http\Controllers\Mouvement\SortieController::class, 'createPageSortieIngredient']);
    Route::get('sortie-produit', [\App\Http\Controllers\Mouvement\SortieController::class, 'createPageSortieProduit']);
    Route::post('sortie-produit', [\App\Http\Controllers\Mouvement\SortieController::class, 'createSortieProduit'])->name('sortie-produit');

    # section : inventaires
    Route::get('inventaire-tous',[\App\Http\Controllers\Inventaire\InventaireController::class, 'showInventaireTous']);
    Route::get('inventaire-produit', [\App\Http\Controllers\Inventaire\InventaireController::class, 'showInventaireProduit']);
    Route::get('inventaire-ingredient', [\App\Http\Controllers\Inventaire\InventaireController::class, 'showInventaireIngredient']);
    Route::get('inventaire-non-consommable ', [\App\Http\Controllers\Inventaire\InventaireController::class, 'showInventaireNonConsommable']);

        # inventaire/details
        Route::get('inventaire/detail-ingredient/{code_produit}', [\App\Http\Controllers\Inventaire\Detail\DetailIngredientController::class, 'showInventaireDetailIngredient']);
        Route::get('inventaire/detail-ingredient/{code_produit}/mouvement-produit', [\App\Http\Controllers\Inventaire\Detail\DetailProduitIngredientController::class, 'showProduitIngredientDetail']);
        Route::get('inventaire/detail-produit/{code_produit}', [\App\Http\Controllers\Inventaire\Detail\DetailProduitController::class, 'showInventaireDetailProduit']);
        Route::get('inventaire/detail-non-consommable/{code_produit}', [\App\Http\Controllers\Inventaire\Detail\DetailNonConsommableController::class, 'showInventaireDetailNonConsommable']);

    # section : stats
    Route::get('stat/{code_produit}', [\App\Http\Controllers\Stat\StatistiqueController::class, 'showStat']);

    # section : emplacements
    Route::get('emplacements', [\App\Http\Controllers\Crud\EmplacementController::class, 'showEmplacements']);

    # section : couts
    Route::get('couts', [\App\Http\Controllers\Cout\CoutController::class, 'showCoutTypeCategorie']);
    Route::get('cout/detail-cout/{type_categorie}', [\App\Http\Controllers\Cout\CoutController::class, 'showDetailCoutProduit']);
    Route::get('cout/detail/recherche', [\App\Http\Controllers\Cout\CoutController::class, 'showRechercheCout']);

    # section : notifications
    Route::get('actualiser-notification', [\App\Http\Controllers\Actualiser\ActualiserController::class, 'getNotifications']);


    # section : imports & exports
    Route::get('imports', [\App\Http\Controllers\Import\ImportController::class, 'showImportPage']);
    Route::post('import-produit', [\App\Http\Controllers\Import\ImportController::class, 'importProduit'])->name('import.produits');

    Route::get('export-produit', [\App\Http\Controllers\Export\ExportController::class, 'exportProduits']);
    Route::get('export-rapport', [\App\Http\Controllers\Export\ExportController::class, 'exportRapports']);


    Route::get('export-stock', [\App\Http\Controllers\Export\ExportController::class, 'exportExcel']);

    Route::get('/', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboard']);



});
Route::middleware(['auth', 'role:equipe'])->group(function () {

});
Route::middleware(['auth', 'role:cuisinier'])->group(function () {
    Route::get('cuisine-ingredient', [\App\Http\Controllers\Cuisine\CuisineIngredientController::class, 'showInventaireIngredient']);
    Route::get('cuisine/gestion-ingredient/{id_mouvement}', [\App\Http\Controllers\Cuisine\CuisineIngredientController::class, 'showGestionIngredient']);
    Route::post('cuisine/gestion-ingredient/diviser', [\App\Http\Controllers\Cuisine\CuisineIngredientController::class, 'diviserIngredient']);
    Route::post('cuisine/gestion-ingredient/sortie-part-non-confirme', [\App\Http\Controllers\Cuisine\CuisineIngredientController::class, 'sortiePartNonConfirme']);
    Route::post('cuisine/gestion-ingredient/sortie-non-confirme', [\App\Http\Controllers\Cuisine\CuisineIngredientController::class, 'sortieNonConfirme']);

    Route::get('cuisine-confirmation', [\App\Http\Controllers\Cuisine\CuisineIngredientController::class, 'showConfirmationSortie']);
    Route::post('cuisine-confirmation/confirmer', [\App\Http\Controllers\Cuisine\CuisineIngredientController::class, 'confirmerSortie']);
});

