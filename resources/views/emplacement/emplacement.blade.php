@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">


    <div class="content-wrapper">
        <div class="row">


                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Emplacements</h4>
                            <div class="col-lg-4">
                                <label for="search" class="form-label">Recherche: </label>
                                <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." autocomplete="off">
                                <datalist id="datalistOptions" >
                                    @foreach($emplacements as $emplacement)
                                        <option value="{{ $emplacement->emplacement }}">
                                    @endforeach

                                </datalist>
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th onclick="trierTableau(0)">Emplacement <i class="mdi mdi-sort menu-icon"></i></th>
                                        <th onclick="trierTableau(1)">Code <i class="mdi mdi-sort menu-icon"></i></th>
                                        <th onclick="trierTableau(2)">Produit <i class="mdi mdi-sort menu-icon"></i></th>
                                        <th onclick="trierTableau(3, true)">Quantité <i class="mdi mdi-sort menu-icon"></i></th>
                                        <th onclick="trierTableau(4)">Unité <i class="mdi mdi-sort menu-icon"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $previousEmplacement = null;
                                        $couleur1 = '#c5d7f2';
                                        $couleur2 = '#96b2fb';
                                        $couleur = $couleur1;
                                    @endphp
                                    @foreach($v_mouvements as $v_m)
                                        @php
                                            $currentEmplacement = $v_m->id_emplacement;
                                            $couleur = $m_emp->listColor($previousEmplacement, $currentEmplacement, $couleur, $couleur1, $couleur2);
                                        @endphp

                                        <tr style="background-color: {{ $couleur }} ">
                                            <td>{{ $v_m->emplacement }}</td>
                                            <td>{{ $v_m->code }}</td>
                                            <td>{{ $v_m->nom }}</td>
                                            <td>{{ $v_m->reste_en_stock }}</td>
                                            <td>{{ $v_m->unite }}</td>
                                        </tr>
                                        @php
                                            $previousEmplacement = $v_m->id_emplacement;
                                        @endphp
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


        </div>
    </div>
    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>




@endsection
