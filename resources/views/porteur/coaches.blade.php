@extends('layouts.app')

@section('title', 'Liste des Coachs - Plateforme incubation')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <!-- Breadcrumb -->
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des Coachs</a></li>
            </ol>
        </div>
    </div>

    <!-- En-tête -->
    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Liste des Coachs</h1>
        </div>

        <!-- Liste des Coachs -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #3498db; color: white;">
                        <h6 class="m-0 font-weight-bold">Informations des Coachs</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead style="background-color: #3498db; color: white;">
                                    <tr>
                                        <th style="border: 1px solid #2ecc71;">Nom</th>
                                        <th style="border: 1px solid #2ecc71;">Email</th>
                                        <th style="border: 1px solid #2ecc71;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coaches as $coach)
                                        <tr>
                                            <td>{{ $coach->name }}</td>
                                            <td>{{ $coach->email }}</td>
                                            <td>
                                                <a href="{{ route('coach.profile', $coach->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i> Voir le Profil
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Total des coachs : <span class="font-weight-bold">{{ $coaches->count() }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
@endsection
