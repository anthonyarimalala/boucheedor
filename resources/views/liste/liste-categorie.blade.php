@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">



    <div class="row">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Catégories</h4>

                    <table class="table-responsive">
                        <tr>
                            <td><label for="emplacement">Type</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select id="emplacement" class="form-control" name="emplacement">
                                    <option value="0">Tous</option>
                                    <option value="Non_consommable">Non Consommable</option>
                                    <option value="Produit">Produit</option>
                                    <option value="Ingrédient">Ingrédient</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="col-lg-4">
                        <label for="search" class="form-label">Recherche: </label>
                        <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." autocomplete="off">
                        <datalist id="datalistOptions" >
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->categorie }}">
                            @endforeach
                        </datalist>
                    </div>

                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>

                                </thead>
                                <tbody>
                                @foreach($categories as $categorie)
                                    <tr>
                                        <td>{{ $categorie->id }}</td>
                                        <td>{{ $categorie->categorie }}</td>
                                        <td>{{ $categorie->type_categorie }}</td>
                                        <td>
                                            <label class="badge badge-primary"><i class="mdi mdi-pen"></i></label>
                                            <label class="badge badge-danger"><i class="mdi mdi-delete"></i></label>
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


    </div>

    <script src="{{ asset('js/tri-tableau.js') }}"></script>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>




@endsection
