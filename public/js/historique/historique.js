document.addEventListener("DOMContentLoaded", function () {
    const entreeCheckbox = document.getElementById("avec_ingredients_entree");
    const sortieCheckbox = document.getElementById("avec_ingredients_sortie");
    const rows = document.querySelectorAll("#dataTable tbody tr");

    function filterRows() {
        const showEntree = entreeCheckbox.checked;
        const showSortie = sortieCheckbox.checked;

        rows.forEach(row => {
            const isEntree = row.getAttribute("data-entree") === "true";
            const isSortie = row.getAttribute("data-sortie") === "true";

            if ((showEntree && isEntree) || (showSortie && isSortie)) {
                row.style.display = ""; // Afficher
            } else {
                row.style.display = "none"; // Masquer
            }
        });
    }

    // Ajouter des événements aux checkboxes
    entreeCheckbox.addEventListener("change", filterRows);
    sortieCheckbox.addEventListener("change", filterRows);

    // Appliquer le filtre au chargement
    filterRows();
});
