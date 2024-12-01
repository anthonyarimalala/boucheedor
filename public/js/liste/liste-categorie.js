// Fonction de recherche dynamique
document.getElementById('search').addEventListener('keyup', filterTable);

// Fonction de filtre principal
// Fonction de recherche et filtre principal
function filterTable() {
    let input = document.getElementById('search').value.toLowerCase();
    let selectedCategorie = document.getElementById('categorie').value;
    let selectedEmplacement = document.getElementById('emplacement').value;
    let table = document.getElementById('dataTable');
    let rows = table.getElementsByTagName('tr');
    let totalPrix = 0;

    for (let i = 1; i < rows.length - 1; i++) {
        let cells = rows[i].getElementsByTagName('td');
        let codeProduit = cells[0]?.textContent || '';
        let nomProduit = cells[1]?.textContent || '';
        let prixTotal = parseFloat(cells[4]?.textContent.replace(/[^0-9,-]/g, '').replace(',', '.')) || 0;
        let categorie = cells[5]?.textContent || '';
        let emplacement = cells[6]?.textContent || '';

        let rowContainsSearchTerm = codeProduit.toLowerCase().includes(input) || nomProduit.toLowerCase().includes(input);
        let matchesCategorie = selectedCategorie === '0' || categorie === selectedCategorie;
        let matchesEmplacement = selectedEmplacement === '0' || emplacement === selectedEmplacement;

        if (rowContainsSearchTerm && matchesCategorie && matchesEmplacement) {
            rows[i].style.display = '';
            totalPrix += prixTotal;
        } else {
            rows[i].style.display = 'none';
        }
    }

    // Mettre à jour le total des prix avec les espaces
    document.getElementById('prix_total').textContent = new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(totalPrix);
}

document.getElementById('categorie').addEventListener('change', filterTable);
document.getElementById('emplacement').addEventListener('change', filterTable);
document.getElementById('search').addEventListener('keyup', filterTable);
