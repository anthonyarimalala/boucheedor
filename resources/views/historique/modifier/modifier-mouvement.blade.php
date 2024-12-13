@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Modifier un mouvement</h4>

                    <!-- Détails du Mouvement -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td>{{ $mouvement->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Code Produit</th>
                                <td>{{ $mouvement->code_produit }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nom du Produit</th>
                                <td>{{ $mouvement->nom }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Unité</th>
                                <td>{{ $mouvement->unite }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Emplacement</th>
                                <td>{{ $mouvement->emplacement }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Entrée</th>
                                <td>{{ $mouvement->entree ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Sortie</th>
                                <td>{{ $mouvement->sortie ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Raison</th>
                                <td>{{ $mouvement->raison }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Prix Unitaire</th>
                                <td>{{ number_format($mouvement->prix_unitaire, 2, ',', ' ') }} Ariary</td>
                            </tr>
                            <tr>
                                <th scope="row">Date du Mouvement</th>
                                <td>{{ $mouvement->date_mouvement }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Validé</th>
                                <td>{{ $mouvement->is_validate ? 'Oui' : 'Non' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Formulaire de Modification -->
                    <div class="mt-4">
                        <h5>Modifier le Mouvement</h5>
                        <form action="" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="entree">Entrée</label>
                                <input type="number" class="form-control" id="entree" name="entree" value="{{ old('entree', $mouvement->entree) }}" @if($mouvement->entree==null||$mouvement->est_stockable==0) disabled @endif>
                            </div>

                            <div class="form-group">
                                <label for="sortie">Sortie</label>
                                <input type="number" class="form-control" id="sortie" name="sortie" value="{{ old('sortie', $mouvement->sortie) }}" @if($mouvement->sortie == null) disabled @endif>
                            </div>

                            <div class="form-group">
                                <label for="id_raison">Raison</label>
                                <select class="form-control" id="id_raison" name="id_raison" >
                                    @foreach($raison_mouvements as $rm)
                                        @if($mouvement->id_raison == $rm->id)
                                            <option value="{{ $rm->id }}">{{ $rm->raison }}</option>
                                        @endif
                                    @endforeach
                                    @foreach($raison_mouvements as $rm)
                                        @if($mouvement->id_raison >= 20)
                                            @if($mouvement->id_raison != $rm->id && $rm->id >= 20)
                                                <option value="{{ $rm->id }}">{{ $rm->raison }}</option>
                                            @endif
                                        @else
                                                @if($mouvement->id_raison != $rm->id && $rm->id < 20)
                                                    <option value="{{ $rm->id }}">{{ $rm->raison }}</option>
                                                @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="prix_unitaire">Prix Unitaire</label>
                                <input type="text" class="form-control" id="prix_unitaire" name="prix_unitaire" value="{{ old('prix_unitaire', $mouvement->prix_unitaire) }}" @if($mouvement->entree==null||$mouvement->est_stockable==0) disabled @endif>
                            </div>

                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/historique/historique.js') }}"></script>
@endsection
