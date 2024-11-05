function trierTableau(colonneIndex, isNumber = false) {
    const tableau = document.getElementById('dataTable');
    const tbody = tableau.tBodies[0];
    const lignes = Array.from(tbody.rows);

    const estAscendant = tbody.dataset.sortDirection === 'asc';
    const direction = estAscendant ? -1 : 1;

    lignes.sort((a, b) => {
        const celluleA = a.cells[colonneIndex].innerText;
        const celluleB = b.cells[colonneIndex].innerText;

        // Si isNumber est true, convertir les cellules en nombres pour le tri
        if (isNumber) {
            return (parseFloat(celluleA) - parseFloat(celluleB)) * direction;
        }

        // Sinon, trier comme des chaînes de caractères
        return (celluleA > celluleB ? 1 : -1) * direction;
    });

    // Vider le tbody et ajouter les lignes triées
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    lignes.forEach(ligne => tbody.appendChild(ligne));

    // Mettre à jour la direction de tri
    tbody.dataset.sortDirection = estAscendant ? 'desc' : 'asc';
}
