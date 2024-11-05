@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">


            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Couts</h4>

                        <a href="{{ asset('cout/detail/recherche') }}" class="text-primary">Rechercher</a>

                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                <tr>
                                    <th>Type </th>
                                    <th style="text-align: right">Valeur</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($objets as $objet)
                                        <tr class="type-categorie" onclick="window.location.href='cout/detail-cout/{{ $objet->type_categorie }}';">
                                            <td> {{ $objet->type_categorie }}</td>
                                            <td style="text-align: right"> {{ number_format($objet->prix_total, 2, ',', ' ') }} Ariary</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td> </td>
                                        <td style="text-align: right"> <strong>Total:</strong> {{ number_format($total[0]->prix_total, 2, ',', ' ') }} Ariary</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>







@endsection
