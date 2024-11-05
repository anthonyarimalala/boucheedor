document.getElementById('search').addEventListener('keyup', function () {
    let input = document.getElementById('search').value.toLowerCase();
    let table = document.getElementById('dataTable');
    let rows = table.getElementsByTagName('tr');

    // Boucle à travers toutes les lignes du tableau (sauf les en-têtes)
    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName('td');
        let rowContainsSearchTerm = false;

        // Boucle à travers toutes les colonnes de la ligne
        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().includes(input)) {
                rowContainsSearchTerm = true;
                break;  // Si on trouve le terme de recherche, on arrête de chercher dans cette ligne
            }
        }
        // Affiche ou cache la ligne selon qu'elle contient ou non le terme de recherche
        rows[i].style.display = rowContainsSearchTerm ? '' : 'none';
    }
});
