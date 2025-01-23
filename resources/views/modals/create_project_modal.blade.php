<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Nouveau Projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="modal fade show" id="createProjectModal" style="display: block;" aria-labelledby="createProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #27ae60; color: white;">
                    <h5 class="modal-title" id="createProjectModalLabel">Créer un Nouveau Projet</h5>
                    <button type="button" class="btn-close" onclick="closeIframe()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createProjectForm" method="POST" action="{{ auth()->user()->role->name === 'coach' ? route('coach.projects.store') : route('porteur.projects.store') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="title" class="form-label font-weight-bold">Titre du Projet</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Entrez le titre du projet" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label font-weight-bold">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Entrez une description détaillée du projet" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeIframe()">Annuler</button>
                            <button type="submit" class="btn btn-success" style="background-color: #27ae60 ; color: white;">Créer le Projet</button>
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
        document.getElementById('createProjectForm').addEventListener('submit', function(event) {
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
                    alert('Erreur lors de la création du projet.');
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    </script>
</body>
</html>
