@extends('layouts.app')
@section('content')

    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Variation de stock Journalier</h4>
                <div>
                    <form class="row g-3">
                        <h4>Sélectionner les dates pour les graphes : </h4>
                        <div class="col-md-6">
                            <label for="diagramme_debut" class="form-label">Date debut</label>
                            <input type="date" class="form-control" id="diagramme_debut" name="diagramme_debut">
                        </div>
                        <div class="col-md-6">
                            <label for="diagramme_fin" class="form-label">Date fin</label>
                            <input type="date" class="form-control" id="diagramme_fin" name="diagramme_fin">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </form>
                    <canvas id="stockChart">Debut</canvas>
                    <br>
                    <form class="row g-3" action="{{ asset(request()->path() . '/mouvement-produit') }}" method="get">
                        <h4>Détail de la consommation : </h4>
                        <div class="col-md-6">
                            <label for="date_debut" class="form-label">Date debut</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut">
                        </div>
                        <div class="col-md-6">
                            <label for="date_fin" class="form-label">Date fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </form>
                </div>


                <script>
                    // Récupérer les données du backend (Laravel)
                    const diagrams = @json($diagrams);

                    // Trier les données par date (du plus ancien au plus récent)
                    diagrams.sort((a, b) => new Date(a.date) - new Date(b.date));

                    // Obtenir la dernière date
                    const lastDate = new Date(diagrams[diagrams.length - 1].date);

                    // Générer une séquence de 30 jours à partir de la dernière date
                    const dateRange = [];
                    for (let i = 0; i < 15; i++) {
                        const date = new Date(lastDate);
                        date.setDate(lastDate.getDate() - i); // Décrémente d'un jour à chaque itération
                        dateRange.push(date.toISOString().split('T')[0]); // Format 'YYYY-MM-DD'
                    }

                    // Inverser la séquence pour commencer par la première date
                    dateRange.reverse(); // L'ordre devient du plus ancien au plus récent

                    // Initialiser le tableau des stocks
                    let stocks = [];
                    let lastStock = 0;

                    // Remplir les stocks pour chaque date
                    dateRange.forEach(date => {
                        // Chercher l'entrée correspondant à la date
                        const entry = diagrams.find(d => d.date === date);

                        if (entry) {
                            lastStock = entry.stock; // Met à jour lastStock avec le stock trouvé pour la date
                        }
                        // Ajouter la valeur de lastStock (la dernière valeur trouvée) même s'il n'y a pas d'entrée
                        stocks.push(lastStock);
                    });

                    // Configuration du diagramme
                    const ctx = document.getElementById('stockChart').getContext('2d');
                    const stockChart = new Chart(ctx, {
                        type: 'bar', // Type de diagramme (ligne)
                        data: {
                            labels: dateRange, // Les 30 dernières dates (ordre du plus ancien au plus récent)
                            datasets: [{
                                label: '@if(isset($details[0])) Stock de {{ $details[0]->nom }} @endif',
                                data: stocks, // Les stocks correspondants (0 si pas de données)
                                borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la ligne
                                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de remplissage
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true // Démarrer l'axe Y à 0
                                }
                            },
                            onClick: (event, elements) => {
                                if (elements.length > 0) {
                                    const index = elements[0].index;
                                    const inputDateDebut = document.getElementById('date_debut').value;
                                    const inputDateFin = document.getElementById('date_fin').value;

                                    if(inputDateDebut === "")
                                        document.getElementById('date_debut').value = dateRange[index];
                                    else
                                        document.getElementById('date_fin').value = dateRange[index];
                                }
                            }
                        }
                    });


                </script>

            </div>
        </div>
    </div>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>


@endsection
