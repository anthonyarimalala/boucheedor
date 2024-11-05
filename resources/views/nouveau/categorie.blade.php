@extends('layouts.app')
@section('content')

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Insérer catégorie</h4>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('create-categorie') }}" method="POST">

                @csrf
                <label for="categorie" class="form-label">Catégorie: </label>
                <input class="form-control" id="categorie" type="text" name="categorie" value="{{ old('categorie') }}">
                @if($errors->has('categorie'))
                    <div class="alert alert-danger">
                        {{ $errors->first('categorie') }}
                    </div>
                @endif

                <br>
                <label class="form-label">Type de Catégorie: </label>
                <div class="form-check form-check-inline form-check-primary">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="type_categorie" value="Produit">
                        Produit à vendre
                        <i class="input-helper"></i></label>
                </div>
                <div class="form-check form-check-inline form-check-primary">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="type_categorie" value="Ingredient">
                        Ingredient
                        <i class="input-helper"></i></label>
                </div>
                <div class="form-check form-check-inline form-check-primary">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="type_categorie" value="Non_consommable">
                        Non Consommable
                        <i class="input-helper"></i></label>
                </div>
                @if($errors->has('type_categorie'))
                    <div class="alert alert-danger">
                        {{ $errors->first('type_categorie') }}
                    </div>
                @endif
                <br>

                <label for="description" class="form-label">Description Catégorie: </label>
                <input class="form-control" id="description" type="textarea" name="description"  value="{{ old('description') }}">

                <button type="submit" class="btn btn-primary me-2" style="color: aliceblue">Ajouter la catégorie</button>
            </form>
        </div>
    </div>
</div>

@endsection
