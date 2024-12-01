@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/emplacement/emplacement.css') }}">



        <div class="row">


                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Emplacements</h4>


                            <div class="col-lg-4">
                                <div class="table-responsive">
                                    <table class="table" id="dataTable">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        @foreach($emplacements as $emplacement)
                                            <tr>
                                                <td>{{ $emplacement->id }}</td>
                                                <td>{{ $emplacement->emplacement }}</td>
                                                <td>
                                                    <label class="badge badge-danger"><i class="mdi mdi-delete"></i></label>
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


        </div>

    <script src="{{ asset('js/tri-tableau.js') }}" ></script>
    <script src="{{ asset('js/recherche-tableau.js') }}"></script>




@endsection
