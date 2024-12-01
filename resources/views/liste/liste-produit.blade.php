@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">



    <div class="row">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Liste des tous les articles</h4>
                    <div class="col-lg-4">
                        <label for="search" class="form-label">Recherche: </label>
                        <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." autocomplete="off">
                        <datalist id="datalistOptions">
                            @foreach($v_produits as $vp)
                                <option value="{{ $vp->nom }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-lg-4">
                        <label for="avec_ingredients" class="form-label">Produit: </label>
                        <input id="produit" class="form-check-input" type="checkbox" value="Produit" name="Produit" checked>
                        <label for="ingredient" class="form-label">Ingredient: </label>
                        <input id="ingredient" class="form-check-input" type="checkbox" value="Ingredient" name="Ingredient" checked>
                        <label for="non-consommable" class="form-label">Non Consommable: </label>
                        <input id="non-consommable" class="form-check-input" type="checkbox" value="Non_consommable" name="Non_consommable" checked>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                            <tr>
                                <th onclick="trierTableau(0)">Type<i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(1)">Code <i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(2)">Nom <i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(3)">Categorie <i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(4)">Seuil de <br> réapprovisionnement<i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(5)">Durée limite <br> en stock<i class="mdi mdi-sort menu-icon"></i></th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($v_produits as $vp)
                                <tr class="type-categorie" style="cursor:pointer;">
                                    <td>{{ $vp->type_categorie }}</td>
                                    <td>{{ $vp->code }}</td>
                                    <td>{{ $vp->nom }}</td>
                                    <td>{{ $vp->categorie }}</td>
                                    <td>@if($vp->seuil_reapprovisionnement != 0) {{ $vp->seuil_reapprovisionnement }} {{ $vp->unite }} @endif</td>
                                    <td>{{ $vp->duree_limite }} Jours</td>
                                    <td>
                                        <label class="badge badge-primary"><i class="mdi mdi-pen"></i></label>
                                        <label class="badge badge-danger"><i class="mdi mdi-delete"></i></label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script>
        // Écouter les changements des checkbox et du champ de recherche
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', filterAndSearchTable);
        });

        document.getElementById('search').addEventListener('input', filterAndSearchTable);

        function filterAndSearchTable() {
            // Obtenir les valeurs des checkbox cochées
            const checkedValues = Array.from(document.querySelectorAll('.form-check-input:checked'))
                .map(checkbox => checkbox.value);

            // Récupérer la valeur de recherche
            const searchValue = document.getElementById('search').value.trim().toLowerCase();

            // Sélectionner toutes les lignes du tableau
            const rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(row => {
                // Récupérer le type de catégorie et le nom de la ligne
                const typeCategorie = row.querySelector('td:nth-child(1)').textContent.trim();
                const nomProduit = row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase();

                // Vérifier si la ligne correspond à la recherche et aux checkbox cochées
                const matchesType = checkedValues.includes(typeCategorie);
                const matchesSearch = !searchValue || nomProduit.includes(searchValue);

                // Afficher ou masquer la ligne en fonction des critères
                if (matchesType && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Filtrer initialement le tableau au chargement de la page
        document.addEventListener('DOMContentLoaded', filterAndSearchTable);
    </script>





@endsection
