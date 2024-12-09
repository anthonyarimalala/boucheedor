// Fonction pour filtrer les lignes du tableau en fonction des cases à cocher et de la recherche
function filtrerTableau() {
    var produitChecked = document.getElementById('produit').checked;
    var ingredientChecked = document.getElementById('ingredient').checked;
    var nonConsommableChecked = document.getElementById('non-consommable').checked;
    var searchText = document.getElementById('search').value.toLowerCase();

    // Récupérer toutes les lignes du tableau
    var rows = document.querySelectorAll('#dataTable tbody tr');

    rows.forEach(function(row) {
        // Récupérer le type de la ligne
        var type = row.classList.contains('Produit') ? 'Produit' :
            row.classList.contains('Ingredient') ? 'Ingredient' :
                row.classList.contains('Non_consommable') ? 'Non_consommable' : null;

        // Vérifier si la ligne correspond au filtre des cases à cocher
        var matchesCheckboxFilter = (type === 'Produit' && produitChecked) ||
            (type === 'Ingredient' && ingredientChecked) ||
            (type === 'Non_consommable' && nonConsommableChecked);

        // Vérifier si la ligne correspond au texte de recherche
        var matchesSearchFilter = row.textContent.toLowerCase().includes(searchText);

        // Afficher ou masquer la ligne en fonction des deux filtres
        if (matchesCheckboxFilter && matchesSearchFilter) {
            row.style.display = '';  // Afficher la ligne
        } else {
            row.style.display = 'none';  // Masquer la ligne
        }
    });
}

// Ajouter des écouteurs d'événements pour chaque case à cocher et le champ de recherche
document.getElementById('produit').addEventListener('change', filtrerTableau);
document.getElementById('ingredient').addEventListener('change', filtrerTableau);
document.getElementById('non-consommable').addEventListener('change', filtrerTableau);
document.getElementById('search').addEventListener('input', filtrerTableau);

// Appel initial pour appliquer le filtrage lors du chargement
filtrerTableau();
