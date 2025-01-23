<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Nouvel Utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="modal fade show" id="createUserModal" style="display: block;" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #27ae60; color: white;">
                    <h5 class="modal-title" id="createUserModalLabel">Créer un Nouvel Utilisateur</h5>
                    <button type="button" class="btn-close" onclick="closeIframe()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name" class="form-label font-weight-bold">Nom</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Entrez le nom" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label font-weight-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'email" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="form-label font-weight-bold">Mot de Passe</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Entrez un mot de passe" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label font-weight-bold">Confirmer le Mot de Passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmez le mot de passe" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="role_id" class="form-label font-weight-bold">Rôle</label>
                            <select name="role_id" id="role_id" class="form-control">
                                <option value="" disabled selected>Sélectionnez un rôle</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeIframe()">Annuler</button>
                            <button type="submit" class="btn btn-success" style="background-color: #27ae60; color: white;">Créer l'Utilisateur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonction pour fermer l'iframe
        function closeIframe() {
            window.parent.postMessage({ action: 'closeIframe' }, '*');
        }

        // Soumission du formulaire via AJAX
        document.getElementById('createUserForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
            })
            .then(response => {
                if (response.ok) {
                    window.parent.postMessage({ action: 'closeIframe', status: 'success' }, '*'); // Ferme l'iframe
                } else {
                    alert('Erreur lors de la création de l\'utilisateur.');
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    </script>
</body>
</html>
