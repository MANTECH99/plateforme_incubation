@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')
<style>
.custom-event {
    font-weight: bold !important; /* Texte en gras */
    color: #27ae60 !important; /* Texte en noir */
}

.fc-prev-button, .fc-next-button {
    color: black !important; /* Change la couleur des flèches */
    background-color: transparent; /* Supprime le fond */
    border: none; /* Supprime les bordures */
}

.fc-prev-button:hover, .fc-next-button:hover {
    color: #27ae60 !important; /* Couleur au survol */
}


/* Styles généraux pour les boutons */
.fc-button {
    color: black !important; /* Texte noir */
    background-color: transparent; /* Fond transparent */
    border: 1px solid #27ae60; /* Bordure verte */
}

/* Bouton actif (sélectionné) */
.fc-button.fc-button-active {
    color: white !important; /* Texte blanc */
    background-color: #27ae60 !important; /* Fond vert */
    border-color: #27ae60 !important; /* Bordure verte */
}

/* Boutons au survol */
.fc-button:hover {
    color: white !important; /* Texte blanc */
    background-color: #2ecc71 !important; /* Fond vert clair */
    border-color: #2ecc71 !important; /* Bordure vert clair */
}


</style>

<style>
    .horizontal-sidebar {
    background-color: rgba(30, 125, 50, 0.1); 
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
@if(auth()->user()->role->name == 'porteur de projet')
<div class="container">
    <div class="horizontal-sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('porteur.projects.index') ? 'active' : '' }}" href="{{ route('porteur.projects.index') }}">
                    Mes projets
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('mentorship_sessions.index') ? 'active' : '' }}" href="{{ route('mentorship_sessions.index') }}">
                    Séances de mentorat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('porteur.coaches') ? 'active' : '' }}" href="{{ route('porteur.coaches') }}">
                    Liste des coachs
                </a>
            </li>
        </ul>
    </div>
    <div class="workspace-content mt-4">
        @yield('workspace-content')
    </div>
</div>
@endif

@if(auth()->user()->role->name == 'coach')
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
@endif




<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

@if(auth()->user()->role->name == 'coach')
                <a href="{{ route('google.redirect') }}" class="btn btn-success mb-3"> <i class="fa fa-plus-circle"></i> Se connecter avec Google pour créer une séance</a>
            @endif
        <!-- Table des Séances de Mentorat -->
        <div class="col-12 mt-5">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #27ae60 ; color: white;">
                <h4 class="m-0 font-weight-bold" style=" color: white;">Séances de Mentorat</h4>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead style="background-color: #27ae60 ; color: white;">
                            <tr>
                                <th style="border: 1px solid #2ecc71;">Projet</th>
                                <th style="border: 1px solid #2ecc71;">Coach</th>
                                <th style="border: 1px solid #2ecc71;">Date de début</th>
                                <th style="border: 1px solid #2ecc71;">Date de fin</th>
                                <th style="border: 1px solid #2ecc71;">Notes</th>
                                <th style="border: 1px solid #2ecc71;">Lien de la réunion</th>
                                <th style="border: 1px solid #2ecc71;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td>{{ $session->project->title }}</td>
                                    <td>{{ $session->coach->name }}</td>
                                    <td>{{ $session->start_time}}</td>
                                    <td>{{ $session->end_time}}</td>
                                    <td>{{ $session->notes ?? 'Aucune note' }}</td>
                                    <td>
    @if($session->meeting_link)
        <a href="{{ $session->meeting_link }}" target="_blank">Rejoindre la réunion</a>
    @else
        Non défini
    @endif
</td>
                                    <td>
                                    
                                        @if(auth()->user()->role->name === 'coach')
                                            <div class="btn-group">
                                                <form action="{{ route('mentorship_sessions.destroy', $session->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Total des séances : <span class="font-weight-bold">{{ $sessions->count() }}</span></p>
                </div>
    <!-- Calendrier des Séances -->
    <div class="col-12 mt-5">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #27ae60 ; color: white;">
                <h4 class="m-0 font-weight-bold" style=" color: white;">Calendrier des Séances de Mentorat</h4>
            </div>
            <div class="card-body">
                <div id="calendar" style="margin-bottom: 30px;"></div>
            </div>
        </div>
    </div>


            </div>
        </div>
    </div>

</div>

<!-- JS spécifique -->
@vite('resources/js/mentorship_calendar.js')

@endsection
