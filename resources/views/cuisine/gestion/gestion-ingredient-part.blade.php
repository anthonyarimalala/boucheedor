@extends('layouts.app')
@section('content')

    <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title card-title-dash">{{ $v_mouvement->nom }} ({{ $v_mouvement->reste_en_stock }} {{ $v_mouvement->unite }}) </h4>
                                        <p class="card-subtitle card-subtitle-dash">{{ $v_mouvement->emplacement }}</p>
                                    </div>


                                </div>
                                @if($errors->has('error'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('error') }}
                                    </div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif


                                <form class="row g-3" action="{{ asset('cuisine/gestion-ingredient/sortie-part-non-confirme') }}" method="POST">
                                @csrf
                                <input type="number" name="id_mouvement" value="{{ isset($parts[0]) ? $parts[0]->id_mouvement : '' }}" hidden>
                                    <input type="text" name="nom_produit" value="{{ $v_mouvement->nom }}" hidden>
                                    <input type="text" name="unite" value="{{ $v_mouvement->unite }}" hidden>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>
                                                Numéro
                                            </th>
                                            <th>
                                                Quantité Initial
                                            </th>
                                            <th>
                                                Quantité Actuelle
                                            </th>
                                            <th>
                                                Emplacement
                                            </th>
                                            <th>
                                                Sortie
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($parts as $part)
                                            <tr>
                                                <td style="text-align: right">{{ $part->numero }}</td>
                                                <td style="text-align: right">@if($v_mouvement->unite == 'kg') <span style="color: blue">{{ $part->quantite_initiale*1000 }} g </span> / @endif {{ $part->quantite_initiale }} {{ $v_mouvement->unite }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: {{ ($part->stock/$part->quantite_initiale)*100 }}%; background-color: #919BA5" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    @if($v_mouvement->unite == 'kg') <span style="color: blue">{{ $part->stock*1000 }} g </span>/ @endif {{ $part->stock }} {{ $v_mouvement->unite }} <br>
                                                </td>
                                                <td>{{ $part->emplacement }}</td>
                                                <td>
                                                    @if($v_mouvement->unite == 'kg')
                                                        <input id="sortie_g-{{ $part->numero }}" type="number" name="sortie_g"> g <br>
                                                    @endif
                                                    <input id="sortie_kg-{{ $part->numero }}" type="number" step="0.001" name="numeros[{{ $part->numero }}]" min="0"> {{ $v_mouvement->unite }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-6" style="color: white">Valider</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row flex-grow">
                        <div class="col-6 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Mes sorties</h4>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                @foreach($v_cuisine_sortie_non_confirmes as $vc)
                                                    <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                        <div class="d-flex">
                                                            <div class="wrapper ms-3">
                                                                <p class="ms-1 mb-1 fw-bold">{{ $vc->nom_produit }}</p>
                                                                <small class="text-muted mb-0">@if($vc->unite == 'kg') <span style="color: blue">{{ $vc->som_sortie*1000 }} g </span>/ @endif {{ $vc->som_sortie }} {{ $vc->unite }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted text-small">
                                                            1h ago
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cuisine/conversion.js') }}"></script>

    <script>
        @foreach($parts as $part)
            setupConversion('sortie_g-{{ $part->numero }}', 'sortie_kg-{{ $part->numero }}');
        @endforeach
    </script>


@endsection
