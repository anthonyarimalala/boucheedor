@extends('layouts.app')
@section('content')

    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Journalier</h4>
                <div>
                    <canvas id="stockChart">Debut</canvas>
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
                        type: 'bar', // Type de diagramme (ligne)
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
    <div class="col-lg-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Details</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                Code
                            </th>
                            <th>
                                Produit
                            </th>
                            <th>
                                Entree
                            </th>
                            <th>
                                Sortie
                            </th>
                            <th>
                                Stock
                            </th>
                            <th>
                                Date
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($details as $detail)
                            <tr style="background-color: {{ $v->mouvementColor($detail) }}">
                                <td>
                                    {{ $detail->code_produit }}
                                </td>
                                <td>
                                    {{ $detail->nom }}
                                </td>
                                <td>
                                    {{ $detail->entree }}
                                </td>
                                <td>
                                    {{ $detail->sortie }}
                                </td>
                                <td>
                                    {{ $detail->stock }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($detail->date_mouvement)->format('d F Y H:i')  }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>

@endsection
