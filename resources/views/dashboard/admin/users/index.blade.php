@extends('layouts.app')

@section('title', 'Liste des Utilisateurs')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <!-- Container Fluid-->
    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Liste des Utilisateurs</h1>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control me-2" placeholder="Rechercher un utilisateur..." style="width: 250px;">
                <button class="btn btn-md" style="background-color: #27ae60; color: white;" onclick="showIframe('{{ route('admin.users.create') }}')"> Ajouter un utilisateur</button>
            </div>
        </div>
        <iframe 
    id="modalFrame" 
    src="" 
    style="width: 100%; height: 700px; border: none; display: none;" 
    scrolling="auto">
</iframe>

<script>
    // Fonction pour afficher l'iframe avec le formulaire approprié
// Fonction pour afficher l'iframe avec le formulaire approprié
function showIframe(url) {
    const iframe = document.getElementById('modalFrame');
    iframe.src = url; // Définit la source de l'iframe (formulaire d'ajout ou de modification)
    iframe.style.display = 'block'; // Affiche l'iframe
}

    // Fonction pour fermer l'iframe
    window.addEventListener('message', function(event) {
        if (event.data.action === 'closeIframe') {
            const iframe = document.getElementById('modalFrame');
            iframe.style.display = 'none'; // Cache l'iframe
            if (event.data.status === 'success') {
                alert('Utilisateur créé/modifié avec succès !');
                location.reload(); // Recharge la page pour afficher les mises à jour
            }
        }
    });
</script>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Table des utilisateurs -->
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-items-center">
                            <thead style="background-color: #27ae60 ; color: white;">
                                <tr>
                                    <th style="border: 1px solid #6c757d;">Nom</th>
                                    <th style="border: 1px solid #6c757d;">Email</th>
                                    <th style="border: 1px solid #6c757d;">Rôle</th>
                                    <th style="border: 1px solid #6c757d;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="border: 1px solid #6c757d;">{{ $user->name }}</td>
                                        <td style="border: 1px solid #6c757d;">{{ $user->email }}</td>
                                        <td style="border: 1px solid #6c757d;">{{ $user->role->name }}</td>
                                        <td style="border: 1px solid #6c757d;">
                                            <!-- Bouton pour ouvrir la modal -->
                                            <button class="btn btn-sm" style="background-color: #27ae60     ; color: white;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                Modifier
                                            </button>
                                                <!-- Bouton Supprimer -->
    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
            Supprimer
        </button>
    </form>
                                        </td>
                                    </tr>
                                    <!-- Modal pour chaque utilisateur -->
                                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #27ae60 ; color: white;">
                                                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Modifier l'Utilisateur : {{ $user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                                                        @csrf
                                                        @method('PATCH')

                                                        <div class="form-group mb-4">
                                                            <label for="name{{ $user->id }}" class="form-label">Nom</label>
                                                            <input type="text" name="name" id="name{{ $user->id }}" class="form-control" value="{{ $user->name }}" required>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="email{{ $user->id }}" class="form-label">Email</label>
                                                            <input type="email" name="email" id="email{{ $user->id }}" class="form-control" value="{{ $user->email }}" required>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="role_id{{ $user->id }}" class="form-label">Rôle</label>
                                                            <select name="role_id" id="role_id{{ $user->id }}" class="form-control" required>
                                                                @foreach($roles as $role)
                                                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                        {{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-md" style="background-color: #27ae60     ; color: white;">Mettre à Jour</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Annuler</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center" style="background-color: #ecf0f1;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
