function showEditModal(button) {
    // Récupérer l'ID du produit depuis l'attribut data-id
    var productId = button.getAttribute('data-id');

    // Faire une requête AJAX pour récupérer les détails du produit
    fetch(`/liste-produit/modifier/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Remplir les champs du formulaire avec les données du produit
            document.getElementById('code').value = data.v_produit.code;
            document.getElementById('nom').value = data.v_produit.nom;
            document.getElementById('seuil_reapprovisionnement').value = data.v_produit.seuil_reapprovisionnement;
            document.getElementById('duree_limite').value = data.v_produit.duree_limite;

            // Remplir la liste déroulante des unités
            var uniteSelect = document.getElementById('unite');
            uniteSelect.innerHTML = '<option value="" disabled>Choisir une unité</option>'; // Réinitialiser
            var currentUniteOption = document.createElement('option');
            currentUniteOption.value = data.v_produit.unite;
            currentUniteOption.textContent = data.v_produit.unite;
            currentUniteOption.selected = true;
            uniteSelect.appendChild(currentUniteOption);
            data.unites.forEach(unite => {
                if (unite.unite !== data.v_produit.unite) { // Ajouter uniquement si différente
                    var option = document.createElement('option');
                    option.value = unite.unite;
                    option.textContent = unite.unite;
                    uniteSelect.appendChild(option);
                }
            });

            // Remplir la liste déroulante des catégories
            var categorieSelect = document.getElementById('categorie');
            categorieSelect.innerHTML = '<option value="" disabled>Choisir une catégorie</option>'; // Réinitialiser
            var currentCategorieOption = document.createElement('option');
            currentCategorieOption.value = data.v_produit.id_categorie;
            currentCategorieOption.textContent = data.v_produit.categorie;
            currentCategorieOption.selected = true; // Sélectionner par défaut
            categorieSelect.appendChild(currentCategorieOption);
            data.categories.forEach(categorie => {
                if (categorie.id !== data.v_produit.id_categorie) { // Ajouter uniquement si différente
                    var option = document.createElement('option');
                    option.value = categorie.id;
                    option.textContent = categorie.categorie;
                    categorieSelect.appendChild(option);
                }
            });



            // Remplir la liste déroulante des emplacements
            var emplacementSelect = document.getElementById('emplacement');
            emplacementSelect.innerHTML = '<option value="" disabled>Choisir un emplacement</option>'; // Réinitialiser
            var currentEmplacementOption = document.createElement('option');
            currentEmplacementOption.value = data.v_produit.id_emplacement_defaut;
            currentEmplacementOption.textContent = data.v_produit.emplacement;
            currentEmplacementOption.selected = true;
            emplacementSelect.appendChild(currentEmplacementOption);
            data.emplacements.forEach(emplacement => {
                if (emplacement.id !== data.v_produit.id_emplacement_defaut) { // Ajouter uniquement si différent
                    var option = document.createElement('option');
                    option.value = emplacement.id;
                    option.textContent = emplacement.emplacement;
                    emplacementSelect.appendChild(option);
                }
            });

            // Afficher le modal
            var modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            alert('Une erreur s\'est produite lors de la récupération des détails du produit.');
        });
}


function confirmDelete(event) {
    event.preventDefault(); // Empêche l'action par défaut (si c'est un lien ou un formulaire)


    // Boîte de confirmation native
    var result = confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');

    if (result) {
        // Si l'utilisateur confirme, effectuer l'action de suppression (par exemple, envoyer un formulaire ou une requête Ajax)
        //window.location.href=`#/${productId}`;
        event.target.closest('form').submit();
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
