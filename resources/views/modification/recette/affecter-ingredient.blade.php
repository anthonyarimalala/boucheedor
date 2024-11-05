@extends('layouts.app')
@section('content')


<div class="col-lg-6 grid-margin stretch-card">

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Affectation ingrédient</h4>
            <div class="col-lg-4">
                <label for="search" class="form-label">Recherche: </label>
                <input class="form-control" type="text" id="search" placeholder="Rechercher...">
            </div>
            <form action="{{ asset('modifier-recette/'.$produit->code .'/update-produit-ingredient') }}" method="POST">
                @csrf
                <h5>{{ $produit->nom }}</h5>
                @if($errors->has('no-ingredient'))
                    <div class="alert alert-danger">
                        {{ $errors->first('no-ingredient') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table table-striped" id="dataTable">
                    <thead>
                    <tr>
                        <th>Ingredient </th>
                        <th style="text-align: right">Quantité</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($ingredients as $ingredient)
                            <tr>
                                <td><label for="avec_ingredients" class="form-label">{{ $ingredient->nom }}: </label>
                                    @php
                                        $m_temp = $m_l_produit_ingredient->isChecked($ingredient->code, $produit_ingredients)
                                    @endphp
                                    <input id="avec_ingredients" class="form-check-input" type="checkbox" name="ingredients[]" value="{{ $ingredient->code }}" min="0" @if($m_temp[0]) checked @endif>
                                </td>
                                <td>
                                    <input id="avec_ingredients" type="number" step="0.01" placeholder="Quantite (Optionel)" name="quantite-{{ $ingredient->code }}" min="0" @if($m_temp[1] != null) value="{{ $m_temp[1] }}" @endif>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary me-2" style="color: aliceblue">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/recherche-tableau.js') }}"></script>

@endsection
