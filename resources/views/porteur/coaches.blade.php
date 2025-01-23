@extends('layouts.app')

@section('title', 'Liste des Coachs - Plateforme incubation')

@section('content')

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

    .coach-card {
        margin-bottom: 20px;
    }

    .coach-card-header {
        background-color: #27ae60;
        color: white;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .coach-card-body {
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .coach-card-body .coach-info {
        flex: 1;
    }

    .coach-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }

    .coach-card-footer {
        background-color: #f7f7f7;
        text-align: center;
        padding: 10px;
    }

    .btn-view-profile {
        background-color: #27ae60;
        color: white;
        border-radius: 5px;
    }

    .btn-view-profile:hover {
        background-color: #2ecc71;
    }

    .coach-info p {
        margin-bottom: 10px;
    }

    .coach-info .icon {
        color: #27ae60;
        margin-right: 10px;
    }
    .coach-avatar {
    width: 100px; /* Augmente la largeur */
    height: 100px; /* Augmente la hauteur */
    border-radius: 50%; /* Garde l'image circulaire */
    object-fit: cover; /* Assure que l'image s'adapte sans déformation */
    border: 2px solid #27ae60; /* Ajoute un encadrement vert */
    padding: 5px; /* Espace intérieur */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Ajoute une ombre douce */
}


</style>

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

<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <!-- En-tête -->
    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" 
    style="background-color: rgba(39, 174, 96, 0.1); 
           color: #27ae60; 
           border: 1px solid #27ae60; 
           padding: 10px 15px; 
           border-radius: 5px; 
           display: inline-block; 
           margin: 0 auto; 
           text-align: center; 
           width: 100%;">
    Liste des Coachs
</h1>

        </div>

        <!-- Liste des Coachs -->
        <div class="row">
            @foreach($coaches as $coach)
                <div class="col-lg-4 mb-4 coach-card">
                    <div class="card">
                        <div class="coach-card-header">
                            <span>{{ $coach->name }}</span>
                        </div>
                        <div class="coach-card-body">
                            <div class="coach-info">
                                <p><i class="fa fa-briefcase icon"></i><strong>Fonction:</strong> {{ $coach->fonction }}</p>
                                <p><i class="fa fa-envelope icon"></i><strong>Email:</strong> {{ $coach->email }}</p>
                                <p><i class="fa fa-map-marker-alt icon"></i><strong>Adresse:</strong> {{ $coach->startup_adresse }}</p>
                                <p><i class="fa fa-phone icon"></i><strong>Téléphone:</strong> {{ $coach->telephone }}</p>
                            </div>
                            <div class="profile-img">
                                @if($coach->profile_picture)
                                    <img src="{{ asset('storage/'.$coach->profile_picture) }}" alt="Profile Picture" class="coach-avatar">
                                @else
                                    <img src="{{ asset('images/default-avatar.jpg') }}" alt="Default Avatar" class="coach-avatar">
                                @endif
                            </div>
                        </div>
                        <div class="coach-card-footer">
                            <a href="{{ route('coach.profile', $coach->id) }}" class="btn btn-MD btn-view-profile">
                                <i class="fa fa-eye"></i> Voir le Profil
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total des coachs -->
        <div class="card-footer text-center">
            <p class="mb-0">Total des coachs : <span class="font-weight-bold">{{ $coaches->count() }}</span></p>
        </div>

    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@endsection
