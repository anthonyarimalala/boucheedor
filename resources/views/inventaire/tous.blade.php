@extends('layouts.app')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">
    <div class="col-lg-12 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rapport de stock </h4>
                <a href="" class="btn btn-success btn-sm position-absolute" style="top: 10px; right: 10px;">
                    <i class="mdi mdi-file-excel"></i> Exporter
                </a>
                <div class="col-lg-4">
                    <label for="search" class="form-label">Recherche: </label>
                    <input class="form-control" type="text" id="search" placeholder="Rechercher...">
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
                            <th onclick="trierTableau(0)">
                                Code <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th onclick="trierTableau(1)">
                                Produit <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th onclick="trierTableau(2)">
                                Emplacement <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th onclick="trierTableau(3, true)">
                                Stock <i class="mdi mdi-sort menu-icon"></i>
                            </th>
                            <th>
                                Date entrée
                            </th>
                            <th>
                                Type
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($v_mouvements as $vm)

                            <tr class="type-categorie" onclick="window.location.href='stat/{{ $vm->code_produit }}';" style="cursor:pointer;">
                                <td>
                                    {{ $vm->code_produit }}
                                </td>
                                <td>
                                    {{ $vm->nom }}
                                </td>
                                <td>
                                    {{ $vm->emplacement }}
                                </td>
                                <td>
                                    <div class="progress">


                                        <div class="progress-bar" role="progressbar" style="width: {{ $vm->pourcentage }}%; background-color: {{ $m_v_mouvement->couleurObject($vm) }}" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>

                                    </div>
                                    {{ $vm->reste_en_stock }} {{ $vm->unite }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($vm->date_mouvement)->format('d F Y H:i') }}
                                </td>
                                <td>
                                    {{ $vm->type_categorie }}
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
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
                const typeCategorie = row.querySelector('td:nth-child(6)').textContent.trim();
                const nomProduit = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();

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
