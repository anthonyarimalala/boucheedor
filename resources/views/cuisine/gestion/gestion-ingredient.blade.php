@extends('layouts.app')
@section('content')

<div class="tab-content tab-content-basic">
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">  
      <div class="row">
        <div class="col-lg-8 d-flex flex-column">
          
            <div class="col-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">{{ $v_mouvement->nom }} ({{ $v_mouvement->reste_en_stock }} {{ $v_mouvement->unite }}) </h4>
                            <p class="card-subtitle card-subtitle-dash">{{ $v_mouvement->emplacement }}</p>
                        </div>
                        <div>
                          <button 
                            class="btn btn-primary btn-lg text-white mb-0 me-0" 
                            type="button" 
                            data-bs-toggle="modal" 
                            data-bs-target="#divisionModal">
                            <i class="mdi mdi-knife"></i> Diviser
                          </button>
                        </div>
                        @if($errors->has('error'))
                          <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                          </div>
                        @endif
                    </div>
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <label for="emplacement" class="form-label"></label>
                        <table>
                          <tr>
                            @if($v_mouvement->unite == 'kg') 
                              <td>Sortie en g (gramme)</td>
                            @endif
                            <td>Sortie en {{ $v_mouvement->unite }}</td>
                          </tr>
                          <tr>
                            @if($v_mouvement->unite == 'kg') 
                              <td><input class="form-control" id="sortie_g" type="number" name="sortie_g"></td>
                            @endif
                            <td><input class="form-control" id="sortie_kg" type="number" step="0.001" name="sortie"></td>
                            
                          </tr>
                        </table>
                        
                      </div>
                      
                  </div>
                  
                  <div class="table-responsive">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                        <tr>
                            <th>
                                Numéro
                            </th>
                            <th>
                                Quantité Initial
                            </th>
                            <th>
                                Quantité Actuelle
                            </th>
                            <th>
                                Emplacement
                            </th>
                            <th>
                                Sortie
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>

                        </tbody>
                    </table>
                </div>
                </div>
              </div>
            
          </div>
          
        </div>
        <div class="col-lg-4 d-flex flex-column">
          <div class="modal fade" id="divisionModal" tabindex="-1" aria-labelledby="divisionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ asset('cuisine/gestion-ingredient/diviser') }}" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="divisionModalLabel">Division</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input name="id_mouvement" value="{{ $v_mouvement->id }}" hidden>
                    <div class="row">
                      <label for="diviser" class="form-label">A diviser en:</label>
                      <input class="form-control" id="diviser" type="number" name="nbr_divise" min="1" max="20">
                    </div>
                    <div id="dynamic-inputs">
                      <!-- Les champs d'entrée seront ajoutés ici dynamiquement -->
                    </div>
          
                    @if($v_mouvement->unite == 'kg')
                      <div class="col-auto">
                        <span id="unite_en_gramme" class="form-text">
                          Unité en gramme 
                          <input type="checkbox" class="form-check-input" name="unite_en_gramme" value="1" checked>
                        </span>
                      </div>
                    @endif
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" style="color: white">Valider</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title card-title-dash">Type By Amount</h4>
                      </div>
                      <canvas class="my-auto chartjs-render-monitor" id="doughnutChart" height="491" width="737" style="display: block; height: 393px; width: 590px;"></canvas>
                      <div id="doughnut-chart-legend" class="mt-5 text-center"><div class="chartjs-legend"><ul class="justify-content-center"><li><span style="background-color:#1F3BB3"></span>Total</li><li><span style="background-color:#FDD0C7"></span>Net</li><li><span style="background-color:#52CDFF"></span>Gross</li><li><span style="background-color:#81DADA"></span>AVG</li></ul></div></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                          <h4 class="card-title card-title-dash">Leave Report</h4>
                        </div>
                        <div>
                          <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Month Wise </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                              <h6 class="dropdown-header">week Wise</h6>
                              <a class="dropdown-item" href="#">Year Wise</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mt-3"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="leaveReport" width="737" height="187" style="display: block; height: 150px; width: 590px;" class="chartjs-render-monitor"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                          <h4 class="card-title card-title-dash">Top Performer</h4>
                        </div>
                      </div>
                      <div class="mt-3">
                        <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                          <div class="d-flex">
                            <img class="img-sm rounded-10" src="images/faces/face1.jpg" alt="profile">
                            <div class="wrapper ms-3">
                              <p class="ms-1 mb-1 fw-bold">Brandon Washington</p>
                              <small class="text-muted mb-0">162543</small>
                            </div>
                          </div>
                          <div class="text-muted text-small">
                            1h ago
                          </div>
                        </div>
                        <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                          <div class="d-flex">
                            <img class="img-sm rounded-10" src="images/faces/face2.jpg" alt="profile">
                            <div class="wrapper ms-3">
                              <p class="ms-1 mb-1 fw-bold">Wayne Murphy</p>
                              <small class="text-muted mb-0">162543</small>
                            </div>
                          </div>
                          <div class="text-muted text-small">
                            1h ago
                          </div>
                        </div>
                        <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                          <div class="d-flex">
                            <img class="img-sm rounded-10" src="images/faces/face3.jpg" alt="profile">
                            <div class="wrapper ms-3">
                              <p class="ms-1 mb-1 fw-bold">Katherine Butler</p>
                              <small class="text-muted mb-0">162543</small>
                            </div>
                          </div>
                          <div class="text-muted text-small">
                            1h ago
                          </div>
                        </div>
                        <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                          <div class="d-flex">
                            <img class="img-sm rounded-10" src="images/faces/face4.jpg" alt="profile">
                            <div class="wrapper ms-3">
                              <p class="ms-1 mb-1 fw-bold">Matthew Bailey</p>
                              <small class="text-muted mb-0">162543</small>
                            </div>
                          </div>
                          <div class="text-muted text-small">
                            1h ago
                          </div>
                        </div>
                        <div class="wrapper d-flex align-items-center justify-content-between pt-2">
                          <div class="d-flex">
                            <img class="img-sm rounded-10" src="images/faces/face5.jpg" alt="profile">
                            <div class="wrapper ms-3">
                              <p class="ms-1 mb-1 fw-bold">Rafell John</p>
                              <small class="text-muted mb-0">Alaska, USA</small>
                            </div>
                          </div>
                          <div class="text-muted text-small">
                            1h ago
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById("diviser").addEventListener("input", function () {
    const nbrDivise = parseInt(this.value);
    const dynamicInputsContainer = document.getElementById("dynamic-inputs");
    dynamicInputsContainer.innerHTML = ""; // Réinitialiser les champs

    if (!isNaN(nbrDivise) && nbrDivise > 0) {
      for (let i = 1; i <= nbrDivise; i++) {
        // Créer une ligne avec label et input
        const row = document.createElement("div");
        row.className = "row g-3 align-items-center";

        const labelDiv = document.createElement("div");
        labelDiv.className = "col-auto";
        const label = document.createElement("label");
        label.setAttribute("for", `part-${i}`);
        label.className = "col-form-label";
        label.textContent = `Part n°${i}`;
        labelDiv.appendChild(label);

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

        row.appendChild(labelDiv);
        row.appendChild(inputDiv);

        dynamicInputsContainer.appendChild(row);
      }
    }
  });
  </script>
  <script>
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
  </script>
  <script>
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
  </script>

@endsection
