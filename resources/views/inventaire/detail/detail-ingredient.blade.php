@extends('layouts.app')
@section('content')

    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Journalier</h4>
                <div>
                    <form class="row g-3">
                        <h4>Dates à regarder : </h4>
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
                    const codeProduit = diagrams[0]?.code_produit; // Prendre le code_produit de l'un des éléments

                    // Extraire les dates et les stocks
                    const dates = diagrams.map(d => d.date);
                    const stocks = diagrams.map(d => d.stock);

                    // Configuration du diagramme
                    const ctx = document.getElementById('stockChart').getContext('2d');
                    const stockChart = new Chart(ctx, {
                        type: 'line', // Type de diagramme (ligne)
                        data: {
                            labels: dates, // Les dates
                            datasets: [{
                                label: '@if(isset($details[0])) Stock de {{ $details[0]->nom }} @endif' ,
                                data: stocks, // Les stocks
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
                            }
                            ,
                            onClick: (event, elements) => {
                                if (elements.length > 0) {
                                    const index = elements[0].index;
                                    const inputDateDebut = document.getElementById('date_debut').value;
                                    const inputDateFin = document.getElementById('date_fin').value;


                                    if(inputDateDebut === "")
                                        document.getElementById('date_debut').value = dates[index];
                                    else
                                        document.getElementById('date_fin').value = dates[index];
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
