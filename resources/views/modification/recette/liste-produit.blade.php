@extends('layouts.app')
@section('content')

    <div class="col-lg-6 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sélectionner le produit à modifier</h4>
                <ul>
                    @foreach($transformation_locales as $ts)
                        <li><a href="{{ asset('modifier-recette/'. $ts->code .'/update-produit-ingredient') }}">{{ $ts->nom }}</a></li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>

@endsection
