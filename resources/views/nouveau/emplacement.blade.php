@extends('layouts.app')
@section('content')

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Insérer catégorie</h4>
            <form action="" method="POST">
                @csrf
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <label for="emplacement" class="form-label">Emplacement: </label>
                    <input class="form-control" id="emplacement" type="text" name="emplacement">
                @if($errors->has('emplacement'))
                    <div class="alert alert-danger">
                        {{ $errors->first('emplacement') }}
                    </div>
                @endif
                <ul>
                    <li>
                        <label for="Produit">Produit</label>
                        <input id="Produit" class="form-check-input" type="checkbox" name="type_categories[]" value="Produit" min="0">
                    </li>
                    <li>
                        <label for="Non_consommable">Non Consommable</label>
                        <input id="Non_consommable" class="form-check-input" type="checkbox" name="type_categories[]" value="Non_consommable" min="0">
                    </li>
                    <li>
                        <label for="Ingredient">Ingredient</label>
                        <input id="Ingredient" class="form-check-input" type="checkbox" name="type_categories[]" value="Ingredient" min="0">
                    </li>
                </ul>



                <button type="submit" class="btn btn-primary me-2" style="color: aliceblue">Ajouter l'emplacement</button>
            </form>
        </div>
    </div>
</div>

@endsection
