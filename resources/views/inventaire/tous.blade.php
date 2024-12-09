@extends('layouts.app')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">
    <!-- JS Bootstrap -->
    <script src="{{ asset('bootstrap-offline-docs-5.1/dist/js/bootstrap.bundle.min.js') }}"></script>

    <div class="col-lg-12 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rapport de stock </h4>
                <a href="#" class="btn btn-success btn-sm position-absolute" style="top: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#exportPopup">
                    <i class="mdi mdi-file-excel"></i> Exporter
                </a>
                <div class="col-lg-4">
                    <label for="search" class="form-label">Recherche: </label>
                    <input class="form-control" type="text" id="search" placeholder="Rechercher...">
                </div>

                <div class="col-lg-4">
                    <label for="avec_ingredients" class="form-label">Produit: </label>
                    <input id="produit" class="form-check-input" type="checkbox" value="Produit" name="Produit" checked>
                    <label for="ingredient" class="form-label">Ingredient: </label>
                    <input id="ingredient" class="form-check-input" type="checkbox" value="Ingredient" name="Ingredient" checked>
                    <label for="non-consommable" class="form-label">Non Consommable: </label>
                    <input id="non-consommable" class="form-check-input" type="checkbox" value="Non_consommable" name="Non_consommable" checked>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                        <tr>
                            <th onclick="trierTableau(0)">
                                Code <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th onclick="trierTableau(1)">
                                Produit <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th onclick="trierTableau(2)">
                                Emplacement <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th onclick="trierTableau(3, true)">
                                Stock <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th>
                                Date entrée
                            </th>
                            <th>
                                Type
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($v_mouvements as $vm)
                            <tr class="type-categorie {{ $vm->type_categorie }}" onclick="window.location.href='stat/{{ $vm->code_produit }}';" style="cursor:pointer;">
                                <td>{{ $vm->code_produit }}</td>
                                <td>{{ $vm->nom }}</td>
                                <td>{{ $vm->emplacement }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $vm->pourcentage }}%; background-color: {{ $m_v_mouvement->couleurObject($vm) }}" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    {{ $vm->reste_en_stock }} {{ $vm->unite }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($vm->date_mouvement)->format('d F Y H:i') }}</td>
                                <td>{{ $vm->type_categorie }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Popup Modal -->
                <div class="modal fade" id="exportPopup" tabindex="-1" aria-labelledby="exportPopupLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exportPopupLabel">Options d'exportation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ asset('export-rapport') }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <label for="produit" class="form-label">Produit:</label>
                                        <input id="produit" class="form-check-input" type="checkbox" value="Produit" name="Produit" checked>
                                        <label for="ingredient" class="form-label">Ingrédient:</label>
                                        <input id="ingredient" class="form-check-input" type="checkbox" value="Ingredient" name="Ingredient" checked>
                                        <label for="non-consommable" class="form-label">Non Consommable:</label>
                                        <input id="non-consommable" class="form-check-input" type="checkbox" value="Non_consommable" name="Non_consommable" checked>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script src="{{ asset('js/inventaire/inventaire.js') }}"></script>
@endsection
