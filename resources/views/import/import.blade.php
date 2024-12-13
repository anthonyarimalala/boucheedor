@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/cout/cout.css') }}">

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Premier formulaire -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm p-4">
                            <h5 class="card-title text-center mb-4">Importer des Produits</h5>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ asset('import-produit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="form-label fw-bold">Selectionner un fichier .xlsx :</label>
                                    <input type="file" name="file" id="file" class="form-control form-control-lg" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100">Importer</button>
                            </form>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm p-4">
                            <h5 class="card-title text-center mb-4">Importer les fiches produits</h5>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('import.fiche.produit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="form-label fw-bold">Selectionner un fichier .xlsx :</label>
                                    <input type="file" name="file" id="file" class="form-control form-control-lg" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100">Importer</button>
                            </form>
                        </div>

                    </div>
                    <!-- Deuxième formulaire
                    <div class="col-lg-6">
                        <div class="card shadow-sm p-4">
                            <h5 class="card-title text-center mb-4">Importer des Produits</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="file2" class="form-label fw-bold">Produits :</label>
                                    <input type="file" name="file" id="file2" class="form-control form-control-lg" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100">Importer</button>
                            </form>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>








@endsection
