@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">
    <link rel="stylesheet">



    <div class="row">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Liste des tous les articles</h4>
                    <a href="{{ asset('export-produit') }}" class="btn btn-success btn-sm position-absolute" style="top: 10px; right: 10px;">
                        <i class="mdi mdi-file-excel"></i> Exporter
                    </a>
                    <div class="col-lg-4">
                        <label for="search" class="form-label">Recherche: </label>
                        <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." autocomplete="off">
                        <datalist id="datalistOptions">
                            @foreach($v_produits as $vp)
                                <option value="{{ $vp->nom }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-lg-4">
                        <label for="avec_ingredients" class="form-label">Produit: </label>
                        <input id="produit" class="form-check-input" type="checkbox" value="Produit" name="Produit" checked>
                        <label for="ingredient" class="form-label">Ingredient: </label>
                        <input id="ingredient" class="form-check-input" type="checkbox" value="Ingredient" name="Ingredient" checked>
                        <label for="non-consommable" class="form-label">Non Consommable: </label>
                        <input id="non-consommable" class="form-check-input" type="checkbox" value="Non_consommable" name="Non_consommable" checked>
                    </div>

                    <style>
                        /* Classe pour limiter la largeur de la colonne "Nom" */
                        .col-nom {
                            max-width: 160px; /* Limite la largeur de la colonne */
                            white-space: nowrap; /* Empêche le texte de s'étendre sur plusieurs lignes */
                            overflow: hidden; /* Cache le texte qui dépasse */
                            text-overflow: ellipsis; /* Ajoute "..." pour indiquer que le texte a été tronqué */
                        }
                    </style>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                            <tr>
                                <th onclick="trierTableau(0)">Type<i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(1)">Code <i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(2)">Nom <i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(3)">Categorie <i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(4)">Seuil de <br> réapprovisionnement<i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(5)">Durée limite <br> en stock<i class="mdi mdi-sort menu-icon"></i></th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($v_produits as $vp)
                                <tr class="type-categorie" style="cursor:pointer;">
                                    <td onclick="window.location.href='stat/{{ $vp->code }}';">{{ $vp->type_categorie }}</td>
                                    <td onclick="window.location.href='stat/{{ $vp->code }}';">{{ $vp->code }}</td>
                                    <td class="col-nom" onclick="window.location.href='stat/{{ $vp->code }}';">{{ $vp->nom }}</td>
                                    <td onclick="window.location.href='stat/{{ $vp->code }}';">{{ $vp->categorie }}</td>
                                    <td onclick="window.location.href='stat/{{ $vp->code }}';">@if($vp->seuil_reapprovisionnement != 0) {{ $vp->seuil_reapprovisionnement }} {{ $vp->unite }} @endif</td>
                                    <td onclick="window.location.href='stat/{{ $vp->code }}';">@if($vp->est_stockable == 1 && $vp->duree_limite != 0) {{ $vp->duree_limite }} Jours @endif </td>
                                    <td>

                                            <button class="btn btn-primary" title="Modifier" data-toggle="tooltip" data-placement="top" data-id="{{ $vp->code }}" onclick="showEditModal(this)">
                                                <i class="mdi mdi-pen text-white"></i>
                                            </button>

                                        <button class="btn btn-danger" title="Supprimer" data-toggle="tooltip" data-placement="top" onclick="confirmDelete(event)">
                                            <i class="mdi mdi-delete text-white"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing product -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier le produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ asset('update-produit') }}" method="POST">
                        @csrf
                        <input type="text" name="code" id="code" class="form-control" hidden>

                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom </label>
                            <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" readonly>
                        </div>

                        <!-- Catégorie -->
                        <div class="mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <select name="id_categorie" id="categorie" class="form-control">
                                <option value="" disabled selected>Choisir une catégorie</option>
                                <!-- Les options seront ajoutées dynamiquement en JS -->
                            </select>
                        </div>

                        <!-- Emplacement par défaut -->
                        <div class="mb-3">
                            <label for="emplacement" class="form-label">Emplacement par défaut</label>
                            <select name="id_emplacement" id="emplacement" class="form-control">
                                <option value="" disabled selected>Choisir un emplacement</option>
                                <!-- Les options seront ajoutées dynamiquement en JS -->
                            </select>
                        </div>

                        <!-- Unité -->
                        <div class="mb-3">
                            <label for="unite" class="form-label">Unité</label>
                            <select name="unite" id="unite" class="form-control">
                                <option value="" disabled selected>Choisir une unité</option>
                                <!-- Les options seront ajoutées dynamiquement en JS -->
                            </select>
                        </div>

                        <!-- Seuil de réapprovisionnement -->
                        <div class="mb-3">
                            <label for="seuil_reapprovisionnement" class="form-label">Seuil de réapprovisionnement</label>
                            <input type="number" name="seuil_reapprovisionnement" id="seuil_reapprovisionnement" class="form-control" placeholder="Seuil de réapprovisionnement">
                        </div>

                        <!-- Durée limite -->
                        <div class="mb-3">
                            <label for="duree_limite" class="form-label">Durée limite</label>
                            <input type="number" name="duree_limite" id="duree_limite" class="form-control" placeholder="Durée limite">
                        </div>

                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script src="{{ asset('js/liste/liste-produit.js') }}"></script>



@endsection
