function confirmDeleteEmplacement(event, emplacementName) {
    const confirmation = confirm(`Êtes-vous sûr de vouloir supprimer l'emplacement : "${emplacementName}" ?`);
    if (!confirmation) {
        event.preventDefault(); // Annule la soumission si l'utilisateur choisit "Annuler"
    }
    return confirmation; // Renvoie true pour soumettre le formulaire, sinon false
}
