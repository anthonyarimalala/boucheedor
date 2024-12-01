function setupConversion(sortieGId, sortieKgId) {
    // Récupérer les éléments d'entrée à partir des identifiants passés en paramètres
    const sortieG = document.getElementById(sortieGId);
    const sortieKg = document.getElementById(sortieKgId);

    if (sortieG && sortieKg) {
        // Écouteur pour l'entrée en grammes
        sortieG.addEventListener("input", function () {
            const grams = parseFloat(this.value);
            if (!isNaN(grams)) {
                sortieKg.value = (grams / 1000).toFixed(3); // Conversion en kg
            } else {
                sortieKg.value = ""; // Vider si entrée invalide
            }
        });

        // Écouteur pour l'entrée en kilogrammes
        sortieKg.addEventListener("input", function () {
            const kilograms = parseFloat(this.value);
            if (!isNaN(kilograms)) {
                sortieG.value = (kilograms * 1000).toFixed(0); // Conversion en g
            } else {
                sortieG.value = ""; // Vider si entrée invalide
            }
        });
    } else {
        console.error("Les éléments spécifiés n'existent pas :", sortieGId, sortieKgId);
    }
}
