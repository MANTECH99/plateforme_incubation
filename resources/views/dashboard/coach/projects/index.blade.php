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
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('report.generate') ? 'active' : '' }}" href="{{ route('report.generate') }}">
                    Systéme de reporting
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
    Projets disponibles
</h1>
        </div>

        <div class="row">
        @foreach ($projects as $project)
        @if (is_null($project->coach_id))
                <div class="col-lg-4 mb-4 coach-card">
                    <div class="card">
                        <div class="coach-card-header">
                            <span>Nom du Projet : {{ $project->title }}</span>
                        </div>
                        <div class="coach-card-body">
                            <div class="coach-info">
                                <p><i class="fa fa-briefcase icon"></i><strong>Secteur d'activité :</strong> {{ $project->sector }}</p>
                                <p><i class="fa fa-user icon"></i><strong>Porteur de projet :</strong> {{ $project->user->name }}</p>
                                <p><i class="fa fa-user icon"></i><strong>Partenaires :</strong> {{ $project->partners }}</p>
                                <p><i class="fa fa-user icon"></i><strong>Membres de l'équipe:</strong> {{ $project->team_members}}</p>
                            </div>
 
                                <div class="profile-img">
                                    <i class="fa fa-file-pdf fa-5x" style="color: #d9534f;"></i>
                                </div>
                                </div>
                        <div class="coach-card-footer">
                        <form action="{{ route('coach.projects.accompagner', $project->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-md btn-success" style="background-color: #27ae60     ; color: white;"s>Accompagner ce projet</button>
                                                </form>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>


        <!-- Section Projets Déjà Accompagnés -->
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
    Projets déjà accompagnés
</h1>
        </div>


        <div class="row">
        @foreach ($projects as $project)
        @if (!is_null($project->coach_id))
                <div class="col-lg-4 mb-4 coach-card">
                    <div class="card">
                        <div class="coach-card-header">
                            <span>Nom du Projet : {{ $project->title }}</span>
                        </div>
                        <div class="coach-card-body">
                            <div class="coach-info">
                                <p><i class="fa fa-briefcase icon"></i><strong>Secteur d'activité :</strong> {{ $project->sector }}</p>
                                <p><i class="fa fa-user icon"></i><strong>Porteur de projet :</strong> {{ $project->user->name }}</p>
                                <p><i class="fa fa-user icon"></i><strong>Partenaires :</strong> {{ $project->partners }}</p>
                                <p><i class="fa fa-users icon"></i><strong>Membres de l'équipe :</strong> {{ $project->team_members}}</p>
                                <p><i class="fa fa-hourglass icon"></i><strong>Statut : </strong>  @if ($project->status === 'en cours')
                                                     <span class="badge badge-primary">En cours</span>
                                                @elseif ($project->status === 'à venir')
                                                    <span class="badge badge-warning">À venir</span>
                                                @elseif ($project->status === 'terminé')
                                                     <span class="badge badge-success">Terminé</span>
                                                @else
                                                    <span class="badge badge-danger">Annulé</span>
                                                @endif</p>
                            </div>
                            <div class="profile-img">
                                    <i class="fa fa-file-pdf fa-5x" style="color: #d9534f;"></i>
                                </div>
                        </div>
                        <div class="coach-card-footer">
                        <a href="{{ route('coach.projects.show', $project->id) }}" class="btn btn-md" style="background-color: #27ae60     ; color: white;">Taches associés au Projet</a>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-md" style="background-color: #27ae60     ; color: white;">Détails du Projet</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection
