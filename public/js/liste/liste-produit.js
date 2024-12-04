function confirmDelete(event) {
    event.preventDefault(); // Empêche l'action par défaut (si c'est un lien ou un formulaire)

    // Boîte de confirmation native
    var result = confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');

    if (result) {
        // Si l'utilisateur confirme, effectuer l'action de suppression (par exemple, envoyer un formulaire ou une requête Ajax)
        alert('Élément supprimé');
    } else {
        // Si l'utilisateur annule, ne rien faire
        alert('Suppression annulée');
    }
}

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
