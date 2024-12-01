@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">



    <div class="row">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Liste des tous les articles</h4>

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
                        <label for="avec_ingredients" class="form-label">Entrée: </label>
                        <input id="avec_ingredients" class="form-check-input" type="checkbox" value="entree" name="entree" checked>
                        <label for="avec_ingredients" class="form-label">Sortie: </label>
                        <input id="avec_ingredients" class="form-check-input" type="checkbox" value="sortie" name="sortie" checked >
                    </div>

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
                                <tr class="type-categorie" style="cursor:pointer; background-color: @if($vh->entree!=null) #abfc9f @endif" >
                                    <td>{{ \Carbon\Carbon::parse($vh->date_mouvement)->format('d F Y H') }}h</td>
                                    <td>{{ $vh->code_produit }}</td>
                                    <td>{{ $vh->nom }}</td>
                                    <td>@if($vh->entree!=null) {{ number_format($vh->entree, 2, ',', ' ')  }} {{ $vh->unite }} @endif</td>
                                    <td>@if($vh->sortie!=null) {{ number_format($vh->sortie, 2, ',', ' ')  }} {{ $vh->unite }} @endif</td>
                                    <td style="text-align: right"> {{ number_format($vh->prix_unitaire, 2, ',', ' ') }} Ariary</td>
                                    <td
                                        @if($vh->id_raison == 23) style="background-color: #8be3ff" @endif
                                        @if($vh->id_raison == 22) style="background-color: #ffa6a6" @endif
                                    >{{ $vh->raison }}</td>
                                    <td>{{ $vh->emplacement }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($is_pagined) {{ $v_historiques->links() }} @endif
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>




@endsection
