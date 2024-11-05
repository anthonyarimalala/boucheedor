@extends('layouts.app')
@section('content')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Entrée Ingredient</h4>
                <form action="{{ asset('entree-produit') }}" method="POST">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @csrf
                    <div class="col-lg-4">
                        <label for="date" class="form-label">Date: </label>
                        <input class="form-control" id="date" type="datetime-local" value="12/12/2024" name="date">
                    </div>
                        <div class="col-lg-4">
                            <label for="search" class="form-label">Recherche: </label>
                            <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." value="{{$produit_notif}}">
                            <datalist id="datalistOptions">
                                @foreach($produits as $produit)
                                    <option value="{{ $produit->nom }}">
                                @endforeach
                            </datalist>
                        </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <tr>
                                <th>Code </th>
                                <th>Produit</th>
                                <th>Quantite</th>
                                <th>Prix</th>
                                <th>Emplacement</th>
                            </tr>
                            @foreach($produits as $produit)
                                <tr>
                                    <td>{{ $produit->code }}</td>
                                    <td>{{ $produit->nom }}</td>
                                    <td>
                                        <input id="avec_ingredients" type="number" min="0" step="0.01" placeholder="Entrée (Optionel)" name="produits[{{ $produit->code }}]">
                                        {{ $produit->unite }}
                                    </td>
                                    <td>
                                        <input id="" type="number" min="0" step="0.01" placeholder="Prix Unitaire" name="prix-{{ $produit->code }}"> Ariary
                                        <br><br>
                                        <input id="" type="number" min="0" step="0.01" placeholder="Prix Achat" name="prix-achat-{{ $produit->code }}"> Ariary
                                    </td>
                                    <td>
                                        <select name="emplacement-{{ $produit->code }}">
                                            @foreach($emplacements as $emplacement)
                                                <option value="{{ $emplacement->id }}">{{ $emplacement->emplacement }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach


                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary me-2" style="color: aliceblue">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>

@endsection
