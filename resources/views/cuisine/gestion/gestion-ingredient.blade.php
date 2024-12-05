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

                    </div>
                    @if($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ asset('cuisine/gestion-ingredient/sortie-non-confirme') }}" method="POST">
                        @csrf
                        <input type="number" name="id_mouvement" value="{{ $v_mouvement->id }}" hidden>
                        <input type="text" name="nom_produit" value="{{ $v_mouvement->nom }}" hidden>
                        <input type="text" name="unite" value="{{ $v_mouvement->unite }}" hidden>
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
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-6" style="color: white">Valider</button>
                        </div>
                    </form>


                </div>
              </div>

          </div>

        </div>
        <div class="col-lg-4 d-flex flex-column">
          <div class="modal fade" id="divisionModal" tabindex="-1" aria-labelledby="divisionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ asset('cuisine/gestion-ingredient/diviser') }}" method="POST">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="divisionModalLabel">Division (Recommandé pour les viandes)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input name="id_mouvement" value="{{ $v_mouvement->id }}" hidden>
                      <input type="text" name="unite" value="{{ $v_mouvement->unite }}" hidden>
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
                    <div class="col-lg-12">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                          <h4 class="card-title card-title-dash">Mes sorties</h4>
                        </div>
                      </div>
                        <div class="mt-3">
                            @foreach($v_cuisine_sortie_non_confirmes as $vc)
                                <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div class="d-flex">
                                        <div class="wrapper ms-3">
                                            <p class="ms-1 mb-1 fw-bold">{{ $vc->nom_produit }}</p>
                                            <small class="text-muted mb-0">{{ $vc->som_sortie }} {{ $vc->unite }}</small>
                                        </div>
                                    </div>
                                    <div class="text-muted text-small">
                                        1h ago
                                    </div>
                                </div>
                            @endforeach

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
  <script src="{{ asset('js/cuisine/gestion-ingredient.js') }}"></script>
    <script src=" {{ asset('bootstrap-offline-docs-5.1/dist/js/bootstrap.bundle.min.js') }}"></script>

@endsection
