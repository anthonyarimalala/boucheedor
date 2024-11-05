// Get references to the radio buttons and the div containing the transformation options
const transformationLocale = document.getElementById('transformationLocale');
const produitAchete = document.getElementById('produitAchete');
const transformationOptions = document.getElementById('transformationOptions');

// Add event listeners for changes on the "Source" radio buttons
transformationLocale.addEventListener('change', toggleTransformationOptions);
produitAchete.addEventListener('change', toggleTransformationOptions);

// Function to show or hide transformation options
function toggleTransformationOptions() {
    if (transformationLocale.checked) {
        transformationOptions.style.display = 'block';  // Show the options
    } else {
        transformationOptions.style.display = 'none';   // Hide the options
    }
}
