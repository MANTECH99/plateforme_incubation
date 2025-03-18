@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

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

    <!-- Bouton de création -->
    <div class="d-flex align-items-center">
    <button type="button" class="btn btn-md" style="background-color: #27ae60; color: white;" onclick="showIframe()">
    <i class="fa fa-plus"></i> Créer un Nouveau Projet
</button>&nbsp;&nbsp;
        <input type="text" class="form-control me-2" placeholder="Rechercher un projet..." style="width: 200px; height : 20px">&nbsp;&nbsp;
    </div><br>


    <iframe
    id="modalFrame"
    src="{{ route('modal.create_project') }}"
    style="width: 100%; border: none; height : 510px; display: none;"
    scrolling="no">
</iframe>

<script>
    // Écoute les messages venant de l'iframe
    window.addEventListener('message', function(event) {
        if (event.data.action === 'closeIframe') {
            const iframe = document.getElementById('modalFrame');
            iframe.style.display = 'none'; // Cache l'iframe
            if (event.data.status === 'success') {
                alert('Projet créé avec succès !'); // Message de confirmation
                location.reload(); // Recharge la page pour afficher les mises à jour
            }
        }
    });

    // Fonction pour afficher l'iframe
    function showIframe() {
        const iframe = document.getElementById('modalFrame');
        iframe.style.display = 'block';
    }
</script>




    <!-- Titre principal -->
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
    Mes projets et Tâches associées
</h1>
    </div>

    <div class="row">
    @forelse ($projects as $project)
                <div class="col-lg-4 mb-4 coach-card">
                    <div class="card">
                        <div class="coach-card-header">
                            <span>Nom du Projet : {{ $project->title }}</span>
                        </div>
                        <div class="coach-card-body">
                            <div class="coach-info">
                                <p><i class="fa fa-briefcase icon"></i><strong>Secteur d'activité :</strong> {{ $project->sector }}</p>
                                <p><i class="fa fa-user icon"></i><strong>Coach Assigné :</strong> {{ $project->coach->name ?? 'Non assigné' }}</p>
                        </p>
                        <p><i class="fa fa-user icon"></i><strong>Partenaires :</strong> {{ $project->partners }}</p>
                                <p><i class="fa fa-users icon"></i><strong>Membres de l'équipe :</strong> {{ $project->team_members}}</p>
                                <p><i class="fa fa-hourglass icon"></i><strong>Statut : </strong>  @if ($project->status === 'en cours')
                                                    <i class="bi bi-hourglass-split"></i>  <span class="badge badge-primary">En cours</span>
                                                @elseif ($project->status === 'à venir')
                                                    <i class="bi bi-calendar3"></i> <span class="badge badge-warning">À venir</span>
                                                @elseif ($project->status === 'terminé')
                                                    <i class="bi bi-check-circle-fill"></i> <span class="badge badge-success">Terminé</span>
                                                @else
                                                    <i class="bi bi-x-circle"></i> <span class="badge badge-danger">Annulé</span>
                                                @endif</p>
                            </div>
 
                            <div class="profile-img">
                                    <i class="fa fa-file-pdf fa-5x" style="color: #d9534f;"></i>
                                </div>
                                </div>
                        <!-- Pied de la carte -->
                        <div class="coach-card-footer d-flex justify-content-between align-items-center">

    <!-- Bouton pour afficher le projet -->
    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-md" style="background-color: #27ae60; color: white;">
        Détails du Projet
    </a>
    <a href="{{ route('porteur.projects.tasks', ['project' => $project->id]) }}" class="btn btn-md" style="background-color: #27ae60; color: white;">
                                <i class="fa fa-tasks"></i> Mes Taches
                            </a>

                                                            <!-- Bouton pour modifier le projet -->
    <button type="button" class="btn btn-sm btn-warning" onclick="showEditIframe({{ $project->id }})">
    <i class="fa fa-edit"></i> 
    </button>

    <!-- Bouton pour supprimer le projet -->
    <form action="{{ route('porteur.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce projet ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fa fa-trash"></i> 
        </button>
    </form>


</div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p>Aucun projet disponible.</p>
        </div>
    @endforelse
</div>
    <div class="card-footer bg-light text-center">
                    <small class="text-muted">Dernière mise à jour : {{ now()->format('d/m/Y') }}</small>
                </div>
                    <!-- Modal de modification (iframe) -->
                    <iframe
                        id="modalEditFrame"
                        src=""
                        style="width: 100%; border: none; height: 510px; display: none;"
                        scrolling="no">
                    </iframe>
</div>
<script> // Fonction pour afficher l'iframe de modification
    function showEditIframe(projectId) {
        const iframe = document.getElementById('modalEditFrame');
        iframe.src = "{{ url('porteur/projects') }}/" + projectId + "/edit"; // Remplace par l'URL d'édition du projet
        iframe.style.display = 'block'; // Affiche l'iframe

        // Optionnel: ajouter un mécanisme pour fermer le modal ou l'iframe après la soumission
        window.addEventListener('message', function(event) {
            if (event.data.action === 'closeIframe') {
                iframe.style.display = 'none'; // Cache l'iframe
                if (event.data.status === 'success') {
                    alert('Projet modifié avec succès !'); // Message de confirmation
                    location.reload(); // Recharge la page pour afficher les mises à jour
                }
            }
        });
    }
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection
