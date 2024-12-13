@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Catégories</h4>
                    <div class="col-lg-4">
                        <label for="avec_ingredients" class="form-label">Produit: </label>
                        <input id="produit" class="form-check-input" type="checkbox" value="Produit" name="Produit" checked>
                        <label for="ingredient" class="form-label">Ingredient: </label>
                        <input id="ingredient" class="form-check-input" type="checkbox" value="Ingredient" name="Ingredient" checked>
                        <label for="non-consommable" class="form-label">Non Consommable: </label>
                        <input id="non-consommable" class="form-check-input" type="checkbox" value="Non_consommable" name="Non_consommable" checked>
                    </div>
                    <div class="col-lg-4">
                        <label for="search" class="form-label">Recherche: </label>
                        <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." autocomplete="off">
                        <datalist id="datalistOptions" >
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->categorie }}">
                            @endforeach
                        </datalist>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Catégorie</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $categorie)
                                    <tr class="type-{{ $categorie->type_categorie }}">
                                        <td>{{ $categorie->id }}</td>
                                        <td>{{ $categorie->categorie }}</td>
                                        <td>{{ $categorie->type_categorie }}</td>
                                        <td>
                                            <form action="{{ asset('delete-categorie') }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                <input type="hidden" name="id_categorie" value="{{ $categorie->id }}">
                                                <input type="hidden" name="categorie" value="{{ $categorie->categorie }}">
                                                <button class="btn btn-danger" title="Supprimer" data-toggle="tooltip" data-placement="top">
                                                    <i class="mdi mdi-delete text-white"></i>
                                                </button>
                                            </form>
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
    </div>
    <script src="{{ asset('js/tri-tableau.js') }}"></script>
    <script>
        function confirmDelete(event) {
            const confirmation = confirm("Êtes-vous sûr de vouloir supprimer cette catégorie ?");
            if (!confirmation) {
                event.preventDefault(); // Annule la soumission si l'utilisateur choisit "Annuler"
            }
            return confirmation; // Renvoie true pour soumettre le formulaire, sinon false
        }
    </script>
    <script>
        const checkboxes = document.querySelectorAll('.form-check-input');
        const searchInput = document.getElementById('search');
        const rows = document.querySelectorAll('#dataTable tbody tr');

        // Fonction de filtrage combiné
        function filterTable() {
            const activeFilters = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value.toLowerCase());

            const searchValue = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const rowType = row.classList[0].replace('type-', '').toLowerCase();
                const rowCategory = row.children[1].textContent.toLowerCase();

                // Vérifiez si la ligne correspond aux filtres et à la recherche
                const matchesFilter = activeFilters.includes(rowType);
                const matchesSearch = rowCategory.includes(searchValue);

                // Afficher ou masquer la ligne
                row.style.display = matchesFilter && matchesSearch ? '' : 'none';
            });
        }

        // Ajoutez des événements aux cases à cocher et au champ de recherche
        checkboxes.forEach(checkbox => checkbox.addEventListener('change', filterTable));
        searchInput.addEventListener('input', filterTable);

        // Lancer le filtrage au chargement initial
        document.addEventListener('DOMContentLoaded', filterTable);
    </script>
@endsection
