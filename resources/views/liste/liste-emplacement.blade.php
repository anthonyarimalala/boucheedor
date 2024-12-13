@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">



    <div class="row">


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Emplacements</h4>
                    <div class="col-lg-4">
                        <label for="search" class="form-label">Recherche: </label>
                        <input class="form-control" type="text" list="datalistOptions" id="search" placeholder="Rechercher..." autocomplete="off">
                        <datalist id="datalistOptions" >
                            @foreach($emplacements as $emplacement)
                                <option value="{{ $emplacement->emplacement }}">
                            @endforeach
                        </datalist>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                            <tr>
                                <th onclick="trierTableau(1)">Id <i class="mdi mdi-sort menu-icon"></i></th>
                                <th onclick="trierTableau(0)">Emplacement <i class="mdi mdi-sort menu-icon"></i></th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emplacements as $emp)
                                <tr>
                                    <td>{{ $emp->id }}</td>
                                    <td>{{ $emp->emplacement }}</td>
                                    <td>
                                        <form action="{{ asset('delete-emplacement') }}" method="POST" style="display:inline;" onsubmit="return confirmDeleteEmplacement(event, '{{ $emp->emplacement }}')">
                                            @csrf
                                            <input type="hidden" name="id_emplacement" value="{{ $emp->id }}">
                                            <input type="hidden" name="emplacement" value="{{ $emp->emplacement }}">
                                            <button class="btn btn-danger" title="Supprimer" data-toggle="tooltip" data-placement="top">
                                                <i class="mdi mdi-delete text-white"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>
    <script src="{{ asset('js/liste/liste-emplacement.js') }}"></script>





@endsection
