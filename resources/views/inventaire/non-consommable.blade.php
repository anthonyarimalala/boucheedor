@extends('layouts.app')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">
    <div class="col-lg-12 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Non Consommable</h4>
                <a href="{{ asset('liste/Non_consommable') }}" class="text-primary">Voir tous les non consommables</a>
                <div class="col-lg-4">
                    <label for="search" class="form-label">Recherche: </label>
                    <input class="form-control" type="text" id="search" placeholder="Rechercher...">
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
                                Dernière entrée
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($v_mouvements as $vm)

                            <tr class="type-categorie" onclick="window.location.href='inventaire/detail-non-consommable/{{ $vm->code_produit }}';" style="cursor:pointer;">
                                <td>
                                    {{ $vm->code_produit }}
                                </td>
                                <td>
                                    {{ $vm->nom }}
                                </td>
                                <td>
                                    {{ $vm->emplacement }}
                                </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $vm->pourcentage }}%; background-color: {{ $m_v_mouvement->couleurObject($vm) }}" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    {{ $vm->reste_en_stock }} {{ $vm->unite }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($vm->date_mouvement)->format('d F Y H:i') }}
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
