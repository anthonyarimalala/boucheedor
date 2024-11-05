@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Détail Cout</h4>
                <table class="table-responsive">
                    <tr>
                        <td><label for="emplacement">Emplacement</label></td>
                        <td><label for="categorie">Catégorie</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select id="emplacement" class="form-control" name="emplacement">
                                <option value="0">Tous</option>
                                @foreach($emplacements as $emp)
                                    <option value="{{$emp->emplacement}}">{{ $emp->emplacement }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select id="categorie" class="form-control" name="categorie">
                                <option value="0">Tous</option>
                                @foreach($categories as $cat)
                                    <option value="{{$cat->categorie}}">{{ $cat->categorie }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button type="submit" class="btn btn-primary me-2" style="color: aliceblue">Voir</button></td>
                    </tr>
                </table>
                <div class="col-lg-4">
                    <label for="search" class="form-label">Recherche: </label>
                    <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" >
                        <thead>
                        <tr>
                            <th onclick="trierTableau(0)">Code <i class="mdi mdi-sort menu-icon"></i></th>
                            <th onclick="trierTableau(1)">Nom <i class="mdi mdi-sort menu-icon"></i></th>
                            <th onclick="trierTableau(2, true)">Quantite <i class="mdi mdi-sort menu-icon"></i></th>
                            <th onclick="trierTableau(3, true)">Prix Unitaire <i class="mdi mdi-sort menu-icon"></i></th>
                            <th onclick="trierTableau(4, true)">Prix Total <i class="mdi mdi-sort menu-icon"></i></th>
                            <th onclick="trierTableau(5)">Categorie <i class="mdi mdi-sort menu-icon"></i></th>
                            <th onclick="trierTableau(6)">Emplacement <i class="mdi mdi-sort menu-icon"></i></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($objets as $objet)
                            <tr>
                                <td> {{ $objet->code_produit }}</td>
                                <td> {{ $objet->nom }}</td>
                                <td style="text-align: right"> {{ number_format($objet->reste_en_stock, 2, ',', ' ') }}</td>
                                <td style="text-align: right"> {{ number_format($objet->prix_unitaire, 2, ',', ' ') }} Ariary</td>
                                <td style="text-align: right"> {{ number_format($objet->prix_total, 2, ',', ' ') }} Ariary</td>
                                <td> {{ $objet->categorie }}</td>
                                <td> {{ $objet->emplacement }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>






@endsection
