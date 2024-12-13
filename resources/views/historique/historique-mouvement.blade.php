@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">



    <div class="row">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Historique des mouvements</h4>

                    <div class="col-lg-6">
                        <form class="row g-3">
                            <h4>Sélectionner des dates : </h4>
                            <div class="col-md-6">
                                <label for="date_debut" class="form-label">Date debut</label>
                                <input type="date" class="form-control" id="date_debut" name="date_debut">
                            </div>
                            <div class="col-md-6">
                                <label for="date_fin" class="form-label">Date fin</label>
                                <input type="date" class="form-control" id="date_fin" name="date_fin">
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" style="color: white">Valider</button>
                            </div>
                        </form>
                    </div>
                    <br>

                    <div class="col-lg-4">
                        <label for="search" class="form-label">Recherche: </label>
                        <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." autocomplete="off">
                    </div>
                    <br>
                    <div class="col-lg-4">
                        <label for="avec_ingredients_entree" class="form-label">Entrée: </label>
                        <input id="avec_ingredients_entree" class="form-check-input" type="checkbox" value="entree" name="entree" checked>
                        <label for="avec_ingredients_sortie" class="form-label">Sortie: </label>
                        <input id="avec_ingredients_sortie" class="form-check-input" type="checkbox" value="sortie" name="sortie" checked>
                    </div>

                @if($is_pagined){{ $v_historiques->links('pagination::bootstrap-4') }} @endif
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Code </th>
                                <th>Nom </th>
                                <th>Entrée</th>
                                <th>Sortie</th>
                                <th>Prix Unitaire</th>
                                <th>Raison</th>
                                <th>Emplacement </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($v_historiques as $vh)
                                <tr class="type-categorie"
                                    data-id="{{ $vh->id }}"
                                    data-entree="{{ $vh->entree != null ? 'true' : 'false' }}"
                                    data-sortie="{{ $vh->sortie != null ? 'true' : 'false' }}"
                                    style="  cursor:pointer; background-color: @if($vh->entree!=null && $vh->sortie==null) #abfc9f @endif"
                                    onclick="window.location.href='mouvement/{{ $vh->id }}';">
                                    <td>{{ \Carbon\Carbon::parse($vh->date_mouvement)->format('d F Y H') }}h</td>
                                    <td>{{ $vh->code_produit }}</td>
                                    <td>{{ $vh->nom }}</td>
                                    <td>@if($vh->entree!=null) {{ number_format($vh->entree, 2, ',', ' ')  }} {{ $vh->unite }} @if($vh->is_validate == 0) <i class="mdi mdi-alert"></i> @endif @endif</td>
                                    <td>@if($vh->sortie!=null) {{ number_format($vh->sortie, 2, ',', ' ')  }} {{ $vh->unite }} @if($vh->is_validate == 0) <i class="mdi mdi-alert"></i> @endif @endif</td>
                                    <td style="text-align: right"> {{ number_format($vh->prix_unitaire, 2, ',', ' ') }} Ariary @if($vh->entree!=null) <i class="mdi mdi-alert"></i> @endif</td>
                                    <td
                                        @if($vh->id_raison == 23) style="background-color: #ffa6a6" @endif
                                    @if($vh->id_raison == 22) style="background-color: #8be3ff" @endif
                                    >{{ $vh->raison }}</td>
                                    <td>{{ $vh->emplacement }} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($is_pagined){{ $v_historiques->links('pagination::bootstrap-4') }} @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/historique/historique.js') }}"></script>






@endsection
