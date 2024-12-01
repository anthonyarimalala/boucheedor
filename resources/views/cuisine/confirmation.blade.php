@extends('layouts.app')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">

    <div class="col-lg-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Confirmation des sorties</h4>
                <div class="col-lg-4">
                    <label for="search" class="form-label">Recherche: </label>
                    <input class="form-control" type="text" id="search" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                        <tr>
                            <th>
                                Produit
                            </th>
                            <th>
                                Numero
                            </th>
                            <th>
                                Sortie
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($v_non_confirmes as $vnc)

                            <tr class="type-categorie" style="cursor:pointer;">
                                <td>
                                    {{ $vnc->nom_produit }}
                                </td>
                                <td>
                                    {{ $vnc->numero }}
                                </td>
                                <td>
                                    @if($vnc->unite == 'kg') <span style="color: blue">{{ $vnc->som_sortie*1000 }} g </span>/ @endif {{ $vnc->som_sortie }} {{ $vnc->unite }}
                                </td>
                                <td>
                                    <form action="{{ asset('cuisine-confirmation/confirmer') }}" method="POST">
                                        @csrf
                                        <input type="text" name="id_mouvement" value="{{ $vnc->id_mouvement }}" hidden>
                                        <input type="text" name="numero" value="{{ $vnc->numero }}" hidden>
                                        <input type="number" name="sortie" value="{{ $vnc->som_sortie }}" hidden>
                                        <button class="btn btn-success btn-sm me-2" title="confirmer">
                                            <i class="mdi mdi-check-circle-outline"></i>
                                        </button>
                                    </form>
                                    <form>
                                        @csrf
                                        <input type="text" name="id_mouvement" value="{{ $vnc->id_mouvement }}" hidden>
                                        <input type="text" name="numero" value="{{ $vnc->numero }}" hidden>
                                        <button class="btn btn-danger btn-sm me-2" title="alerter">
                                            <i class="mdi mdi-alert-circle-outline"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>
    <script src="{{ asset('js/tri-tableau.js') }}" ></script>

@endsection
