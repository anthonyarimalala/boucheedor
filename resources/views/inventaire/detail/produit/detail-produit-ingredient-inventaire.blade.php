@extends('layouts.app')
@section('content')

    <div class="col-lg-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Details de consommation d'ingredient</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                Code
                            </th>
                            <th>
                                Produit
                            </th>
                            <th>
                                Quantite
                            </th>
                            <th>
                                Unité
                            </th>
                            <th>
                                Date
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($details as $detail)
                            <tr>
                                <td>
                                    {{ $detail->code_produit }}
                                </td>
                                <td>
                                    {{ $detail->nom }}
                                </td>
                                <td>
                                    {{ $detail->entrees }}
                                </td>
                                <td>
                                    {{ $detail->unite }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($detail->date)->format('d F Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
