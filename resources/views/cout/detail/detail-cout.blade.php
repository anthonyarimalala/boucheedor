@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Détail Cout</h4>
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                <tr>
                                    <th>Code </th>
                                    <th>Nom </th>
                                    <th>Quantite </th>
                                    <th>Prix Unitaire </th>
                                    <th>Prix Total </th>
                                    <th>Categorie </th>
                                    <th>Emplacement </th>

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






@endsection
