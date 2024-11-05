@extends('layouts.app')
@section('content')

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Insérer ingrédient</h4>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="" method="POST">
                @csrf
                <label for="produit" class="form-label">Nom Ingrédient: </label>
                <input class="form-control" id="produit" type="text" name="nom" placeholder="Nom ingrédient" value="{{ old('nom') }}">
                @if($errors->has('nom'))
                    <div class="alert alert-danger">
                        {{ $errors->first('nom') }}
                    </div>
                @endif

                <label for="description" class="form-label">Description Ingredient: </label>
                <input class="form-control" id="description" type="text" name="description" placeholder="Description ingrédient" value="{{ old('description') }}">

                <label for="categorie" class="form-label">Catégorie: </label>
                <select id="categorie"  name="id_categorie" class="form-control">
                    <option></option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->categorie }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_categorie'))
                    <div class="alert alert-danger">
                        {{ $errors->first('id_categorie') }}
                    </div>
                @endif

                <label for="unite" class="form-label">Unité: </label>
                <select id="unite"  name="unite" class="form-control">
                    <option></option>
                    @foreach($unites as $uni)
                        <option value="{{ $uni->unite }}">{{ $uni->signification }} ({{ $uni->unite }})</option>
                    @endforeach
                </select>
                @if($errors->has('unite'))
                    <div class="alert alert-danger">
                        {{ $errors->first('unite') }}
                    </div>
                @endif

                <label for="seuil_reapprovisionnement" class="form-label">Seuil de reapprovisionnement: </label>
                <input class="form-control" id="seuil_reapprovisionnement" type="number" name="seuil_reapprovisionnement" placeholder="Seuil de reapprovisionnement">
                @if($errors->has('seuil_reapprovisionnement'))
                    <div class="alert alert-danger">
                        {{ $errors->first('seuil_reapprovisionnement') }}
                    </div>
                @endif

                <label for="duree_limite" class="form-label">Durée limite en stock(en Jours): </label>
                <input class="form-control" id="duree_limite" type="number" min="0" name="duree_limite" placeholder="Durée limite en stock" value="{{ old('duree_limite') }}">

                <button type="submit" class="btn btn-primary me-2" style="color: aliceblue">Ajouter le produit</button>
            </form>
        </div>
    </div>
</div>

@endsection
