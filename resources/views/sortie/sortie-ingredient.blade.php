@extends('layouts.app')
@section('content')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sortie Ingredient</h4>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ asset('sortie-produit') }}" method="POST">
                    @csrf
                    <div class="col-lg-2">
                        <label for="date" class="form-label">Date: </label>
                        <input class="form-control" id="date" type="datetime-local" name="date">
                    </div>
                    <div class="col-lg-4">
                        <label for="search" class="form-label">Recherche: </label>
                        <input class="form-control" type="text" id="search" placeholder="Rechercher..." value="{{$produit_notif}}">
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <tr>
                                <th>Code</th>
                                <th>Produit</th>
                                <th>Emplacement</th>
                                <th>Quantité</th>
                                <th>Unité</th>
                                <th>Sortie</th>
                            </tr>
                            @foreach($v_stocks as $v_stock)
                                <tr>
                                    <td class="col-lg-1">{{ $v_stock->code_produit }}</td>
                                    <td class="col-lg-2">{{ $v_stock->nom }}</td>
                                    <td>{{ $v_stock->emplacement }}</td>
                                    <td>{{ $v_stock->reste }} </td>
                                    <td>{{ $v_stock->unite }}</td>
                                    <td><input id="avec_ingredients"
                                               type="number"
                                               min="0"
                                               max="{{ $v_stock->reste }}"
                                               style="width: 100px;"
                                               step="0.01"
                                               placeholder="Sortie ({{ $v_stock->nom }})"
                                               name="stocks[{{ $v_stock->code_produit }},{{ $v_stock->id_emplacement }}]"
                                               value="stocks[{{ $v_stock->code_produit }},{{ $v_stock->id_emplacement }}]" >
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
