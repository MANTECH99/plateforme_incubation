@extends('layouts.app')

@section('title', 'Dashboard - Projets disponibles')

@section('content')

<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <!-- Breadcrumb -->
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Projets disponibles</a></li>
            </ol>
        </div>
    </div>

    <!-- Section Projets Disponibles -->
    <div class="container-fluid p-0 w-100" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Projets disponibles</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-items-center">
                            <thead style="background-color: #3498db; color: white;">
                                <tr>
                                    <th style="border: 1px solid #27ae60;">Titre</th>
                                    <th style="border: 1px solid #27ae60;">Description</th>
                                    <th style="border: 1px solid #27ae60;">Porteur de projet</th>
                                    <th style="border: 1px solid #27ae60;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    @if (is_null($project->coach_id))
                                        <tr>
                                            <td style="border: 1px solid #27ae60;">{{ $project->title }}</td>
                                            <td style="border: 1px solid #27ae60;">{{ $project->description }}</td>
                                            <td style="border: 1px solid #27ae60;">{{ $project->user->name }}</td>
                                            <td style="border: 1px solid #27ae60;">
                                                <form action="{{ route('coach.projects.accompagner', $project->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-info">Accompagner ce projet</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Projets Déjà Accompagnés -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Projets déjà accompagnés</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-items-center">
                            <thead style="background-color: #3498db; color: white;">
                                <tr>
                                    <th style="border: 1px solid #2980b9;">Titre</th>
                                    <th style="border: 1px solid #2980b9;">Description</th>
                                    <th style="border: 1px solid #2980b9;">Porteur de projet</th>
                                    <th style="border: 1px solid #2980b9;">Détail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    @if (!is_null($project->coach_id))
                                        <tr>
                                            <td style="border: 1px solid #2980b9;">{{ $project->title }}</td>
                                            <td style="border: 1px solid #2980b9;">{{ $project->description }}</td>
                                            <td style="border: 1px solid #2980b9;">{{ $project->user->name }}</td>
                                            <td style="border: 1px solid #2980b9;">
                                                <a href="{{ route('coach.projects.show', $project->id) }}" class="btn btn-sm btn-info">Voir Détails</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
