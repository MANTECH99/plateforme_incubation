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
</button>
        <input type="text" class="form-control me-2" placeholder="Rechercher un projet..." style="width: 250px;">
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
        <h1 class="h3 mb-0 text-gray-800">Mes projets et Tâches associées</h1>
    </div>

    <!-- Tableau des projets -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered align-items-center table-flush text-center">
                    <thead style="background-color: #27ae60 ; color: white;">

                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Coach</th>
                                <th>Tâches associées</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->coach->name ?? 'Non assigné' }}</td>
                                    <td>
                                        <a href="{{ route('porteur.projects.tasks', ['project' => $project->id]) }}" class="btn btn-sm" style="background-color: #27ae60     ; color: white;">
                                            <i class="fa fa-tasks"></i> Voir Détails
                                        </a>
                                    </td>
                                    <td>
                    <form action="{{ route('porteur.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce projet ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i> Supprimer
                        </button>
                    </form>
                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun projet disponible.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">Dernière mise à jour : {{ now()->format('d/m/Y') }}</small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
