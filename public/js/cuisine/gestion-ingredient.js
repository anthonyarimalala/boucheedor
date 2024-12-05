// Récupérer les éléments d'entrée
const sortieG = document.getElementById("sortie_g");
const sortieKg = document.getElementById("sortie_kg");

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

// Récupérer l'élément d'entrée pour le nombre de divisions
const nbrDiviseInput = document.getElementById("diviser");
const dynamicInputsContainer = document.getElementById("dynamic-inputs");

// Écouteur d'événement pour le changement de valeur
nbrDiviseInput.addEventListener("input", function () {
    const nbrDivise = parseInt(this.value);
    dynamicInputsContainer.innerHTML = ""; // Réinitialiser les champs

    if (!isNaN(nbrDivise) && nbrDivise > 0) {
        for (let i = 1; i <= nbrDivise; i++) {
            // Créer un conteneur pour chaque champ
            const row = document.createElement("div");
            row.className = "row g-3 align-items-center";

            // Créer le label
            const labelDiv = document.createElement("div");
            labelDiv.className = "col-auto";
            const label = document.createElement("label");
            label.setAttribute("for", `part-${i}`);
            label.className = "col-form-label";
            label.textContent = `Part n°${i}`;
            labelDiv.appendChild(label);

            // Créer l'input
            const inputDiv = document.createElement("div");
            inputDiv.className = "col-auto";
            const input = document.createElement("input");
            input.type = "number";
            input.step = "0.001";
            input.id = `part-${i}`;
            input.className = "form-control";
            input.name = `part-${i}`;
            input.required = true;
            inputDiv.appendChild(input);

            // Ajouter le label et l'input dans la ligne
            row.appendChild(labelDiv);
            row.appendChild(inputDiv);

            // Ajouter la ligne au conteneur
            dynamicInputsContainer.appendChild(row);
        }
    }
});
