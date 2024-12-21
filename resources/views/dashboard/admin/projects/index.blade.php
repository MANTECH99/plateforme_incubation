@extends('layouts.app')

@section('title', 'Liste des Projets')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Liste des Projets</a></li>
            </ol>
        </div>
    </div>
    <!-- Container Fluid-->
    <div class="container-fluid p-0 w-100" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Liste des Projets</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Table des projets -->
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-items-center">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th style="border: 1px solid #6c757d;">Titre</th>
                                    <th style="border: 1px solid #6c757d;">Description</th>
                                    <th style="border: 1px solid #6c757d;">Porteur de Projet</th>
                                    <th style="border: 1px solid #6c757d;">Coach</th>
                                    <th style="border: 1px solid #6c757d;">Date de Création</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td style="border: 1px solid #6c757d;">{{ $project->title }}</td>
                                        <td style="border: 1px solid #6c757d;">{{ Str::limit($project->description, 50, '...') }}</td>
                                        <td style="border: 1px solid #6c757d;">{{ $project->user->name ?? 'Non attribué' }}</td>
                                        <td style="border: 1px solid #6c757d;">{{ $project->coach->name ?? 'Non attribué' }}</td>
                                        <td style="border: 1px solid #6c757d;">{{ $project->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center" style="background-color: #ecf0f1;">
                        <p class="m-0 text-gray-800">Affichage de {{ $projects->count() }} projet(s).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
