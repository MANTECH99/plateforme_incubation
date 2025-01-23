@extends('layouts.app')

@section('title', 'Dashboard - Projets disponibles')

@section('content')



<style>
    .horizontal-sidebar {
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.horizontal-sidebar .nav-tabs {
    border-bottom: none;
    justify-content: center;
}

.horizontal-sidebar .nav-tabs .nav-link {
    color: #333;
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 0;
    transition: all 0.3s ease;
}

.horizontal-sidebar .nav-tabs .nav-link.active {
    background-color: #27ae60;
    color: #fff;
    font-weight: bold;
}

</style>
<div class="container">
    <div class="horizontal-sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('coach.projects.index') ? 'active' : '' }}" href="{{ route('coach.projects.index') }}">
                    Projets à coacher
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('mentorship_sessions.index') ? 'active' : '' }}" href="{{ route('mentorship_sessions.index') }}">
                    Séances de mentorat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('profile.view') ? 'active' : '' }}" href="{{ route('profile.view') }}">
                    Mon Profil
                </a>
            </li>
        </ul>
    </div>
    <div class="workspace-content mt-4">
        @yield('workspace-content')
    </div>
</div>


<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

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
                            <thead style="background-color: #27ae60     ; color: white;">
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
                                            <td style="border: 1px solid #27ae60s;">
                                                <form action="{{ route('coach.projects.accompagner', $project->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" style="background-color: #27ae60     ; color: white;"s>Accompagner ce projet</button>
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
                            <thead style="background-color: #27ae60     ; color: white;">
                                <tr>
                                    <th style="border: 1px solid #27ae60;">Titre</th>
                                    <th style="border: 1px solid #27ae60;">Description</th>
                                    <th style="border: 1px solid #27ae60;">Porteur de projet</th>
                                    <th style="border: 1px solid #27ae60;">Détail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    @if (!is_null($project->coach_id))
                                        <tr>
                                            <td style="border: 1px solid #27ae60;">{{ $project->title }}</td>
                                            <td style="border: 1px solid #27ae60;">{{ $project->description }}</td>
                                            <td style="border: 1px solid #27ae60;">{{ $project->user->name }}</td>
                                            <td style="border: 1px solid #27ae60;">
                                                <a href="{{ route('coach.projects.show', $project->id) }}" class="btn btn-sm" style="background-color: #27ae60     ; color: white;">Voir Détails</a>
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
