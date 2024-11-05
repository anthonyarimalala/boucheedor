@extends('layouts.app')
@section('content')

    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Insérer Produit</h4>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="" method="POST">
                    @csrf
                    <label for="produit" class="form-label">Nom Produit: </label>
                    <input class="form-control" id="produit" type="text" name="nom" placeholder="Nom produit"  value="{{ old('nom') }}" >
                    @if($errors->has('nom'))
                        <div class="alert alert-danger">
                            {{ $errors->first('nom') }}
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

                    <label for="description" class="form-label">Description Du Produit: </label>
                    <input class="form-control" id="description" type="text" name="description" placeholder="Description"  value="{{ old('description') }}" >
                    @if($errors->has('description'))
                        <div class="alert alert-danger">
                            {{ $errors->first('description') }}
                        </div>
                    @endif

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

                    <label for="seuil_reapprovisionnement" class="form-label">Seuil de reapprovisionnement: </label>
                    <input class="form-control" id="seuil_reapprovisionnement" type="number" name="seuil_reapprovisionnement" placeholder="Seuil de reapprovisionnement" value="{{ old('seuil_reapprovisionnement') }}" >
                    @if($errors->has('seuil_reapprovisionnement'))
                        <div class="alert alert-danger">
                            {{ $errors->first('seuil_reapprovisionnement') }}
                        </div>
                    @endif

                    <div class="container mt-4">
                        <!-- Radio buttons for "Source" -->
                        <label class="form-label">Source: </label>
                        <div class="form-check form-check-inline form-check-primary">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="transformation_locale" value="1" id="transformationLocale">
                                Transformation locale
                                <i class="input-helper"></i>
                            </label>
                        </div>
                        <div class="form-check form-check-inline form-check-primary">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="transformation_locale" value="0" id="produitAchete">
                                Produit acheté
                                <i class="input-helper"></i>
                            </label>
                        </div>
                        @if($errors->has('transformation_locale'))
                            <div class="alert alert-danger">
                                {{ $errors->first('transformation_locale') }}
                            </div>
                        @endif

                        <!-- Radio buttons for "Transformation" (initially hidden) -->
                        <div id="transformationOptions" style="display: none;">
                            <label class="form-label">Transformation: </label>
                            <div class="form-check form-check-inline form-check-primary">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="est_stockable" value="1">
                                    Produit stockable
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                            <div class="form-check form-check-inline form-check-primary">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="est_stockable" value="0">
                                    Produit non-stockable
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                        @if($errors->has('est_stockable'))
                            <div class="alert alert-danger">
                                {{ $errors->first('est_stockable') }}
                            </div>
                        @endif
                    </div>


                    <label for="duree_limite" class="form-label">Durée limite en stock (en date): </label>
                    <input class="form-control" id="duree_limite" type="number" min=0 name="duree_limite" placeholder="Durée limite en stock"  value="{{ old('duree_limite') }}" >
                    @if($errors->has('duree_limite'))
                        <div class="alert alert-danger">
                            {{ $errors->first('duree_limite') }}
                        </div>
                    @endif

                    <br/>

                    <button type="submit" class="btn btn-primary me-2" style="color: aliceblue">Ajouter le produit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/display-transformation.js') }}"></script>

@endsection
