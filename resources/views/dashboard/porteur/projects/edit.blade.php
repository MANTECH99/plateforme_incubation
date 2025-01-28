<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Nouveau Projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- CSS personnalisé -->
<style>


    .modal-content {
        background-color: #ecf0f1; /* Une couleur claire pour le fond du modal */
        border-radius: 10px; /* Coins arrondis pour le contenu du modal */
    }

</style>
<div class="modal fade show" id="editProjectForm" style="display: block;" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #27ae60; color: white;">
                <h5 class="modal-title" id="editProjectModalLabel">Modifier un  Projet</h5>
                <button type="button" class="btn-close" onclick="closeIframe()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProjectForm" action="{{ route('porteur.projects.update', ['id' => $project->id]) }}" method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')


                    <!-- Etape 1 : Informations de base -->
                    <div class="step" id="step-1">
                        <div class="form-group mb-4">
                            <label for="title" class="form-label font-weight-bold">Titre du Projet</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title ?? '') }}" placeholder="Entrez le titre du projet" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label font-weight-bold">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Entrez une description détaillée" required>{{ old('description', $project->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Etape 2 : Objectifs et Budget -->
                    <div class="step" id="step-2" style="display: none;">
                        <div class="form-group mb-4">
                            <label for="objectives" class="form-label font-weight-bold">Objectifs</label>
                            <textarea name="objectives" id="objectives" class="form-control" rows="4" placeholder="Quels sont les objectifs du projet ?" required>{{ old('objectives', $project->objectives ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="budget" class="form-label font-weight-bold">Budget Estimé (€)</label>
                            <input type="number" name="budget" id="budget" class="form-control" value="{{ old('budget', $project->budget ?? '') }}" placeholder="Entrez le budget estimé" required>
                        </div>
                    </div>

                    <!-- Etape 3 : Détails du projet -->
                    <div class="step" id="step-3" style="display: none;">
                        <div class="form-group mb-4">
                            <label for="sector" class="form-label font-weight-bold">Secteur d'Activité</label>
                            <select name="sector" id="sector" class="form-control">
                                <option value="technologie" {{ old('sector', $project->sector ?? '') == 'technologie' ? 'selected' : '' }}>Technologie</option>
                                <option value="sante" {{ old('sector', $project->sector ?? '') == 'sante' ? 'selected' : '' }}>Santé</option>
                                <option value="education" {{ old('sector', $project->sector ?? '') == 'education' ? 'selected' : '' }}>Éducation</option>
                                <option value="autres" {{ old('sector', $project->sector ?? '') == 'autres' ? 'selected' : '' }}>Autres</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="status" class="form-label font-weight-bold">Statut Initial du Projet</label>
                            <select name="status" id="status" class="form-control">
                                <option value="en cours" {{ old('status', $project->status ?? '') == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="à venir" {{ old('status', $project->status ?? '') == 'à venir' ? 'selected' : '' }}>À venir</option>
                                <option value="terminé" {{ old('status', $project->status ?? '') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                                <option value="annulé" {{ old('status', $project->status ?? '') == 'annulé' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="start_date" class="form-label font-weight-bold">Date de Début Prévue</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $project->start_date ?? '') }}">
                        </div>
                    </div>

                    <!-- Etape 4 : Partenaires, Membres de l'Équipe et Documents -->
                    <div class="step" id="step-4" style="display: none;">
                        <div class="form-group mb-4">
                            <label for="partners" class="form-label font-weight-bold">Partenaires</label>
                            <input type="text" name="partners" id="partners" class="form-control" value="{{ old('partners', $project->partners ?? '') }}" placeholder="Lister les partenaires (facultatif)">
                        </div>

                        <div class="form-group mb-4">
                            <label for="team_members" class="form-label font-weight-bold">Membres de l'Équipe</label>
                            <div id="team-members-container">
                                @foreach(old('team_members', json_decode($project->team_members ?? '[]')) as $index => $member)
                                    <input type="text" name="team_members[]" class="form-control mb-2" value="{{ $member }}" placeholder="Membre de l'équipe">
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm add-team-member">Ajouter un membre</button>
                        </div>

                        <div class="form-group mb-4">
                            <label for="risks" class="form-label font-weight-bold">Risques Anticipés</label>
                            <textarea name="risks" id="risks" class="form-control" rows="4" placeholder="Listez les risques et les plans de mitigation">{{ old('risks', $project->risks ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="documents" class="form-label font-weight-bold">Documents associés (facultatif)</label>
                            <input type="file" name="documents[]" id="documents" class="form-control" multiple>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="closeIframe()">Annuler</button>
                        <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;" onclick="prevStep()">Précédent</button>
                        <button type="button" class="btn btn-success" id="nextBtn" onclick="nextStep()" style="background-color: #27ae60; color: white;">Suivant</button>
                        <button type="submit" class="btn btn-success" id="submitBtn" style="display: none; background-color: #27ae60; color: white;" >Modifier le Projet</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let currentStep = 1;
    const totalSteps = 4;

    function showStep(step) {
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById(`step-${i}`).style.display = (i === step) ? 'block' : 'none';
        }

        // Mise à jour de l'affichage des boutons
        if (step === 1) {
            document.getElementById('prevBtn').style.display = 'none';
            document.getElementById('nextBtn').style.display = 'inline-block';
            document.getElementById('submitBtn').style.display = 'none';
        } else if (step === totalSteps) {
            document.getElementById('prevBtn').style.display = 'inline-block';
            document.getElementById('nextBtn').style.display = 'none';
            document.getElementById('submitBtn').style.display = 'inline-block';
        } else {
            document.getElementById('prevBtn').style.display = 'inline-block';
            document.getElementById('nextBtn').style.display = 'inline-block';
            document.getElementById('submitBtn').style.display = 'none';
        }
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    // Initialisation
    showStep(currentStep);

    // Fonction pour fermer l'iframe
    function closeIframe() {
        window.parent.postMessage({ action: 'closeIframe' }, '*');
    }


        // Soumettre le formulaire via AJAX et fermer l'iframe si succès
        document.getElementById('editProjectForm').addEventListener('submit', function(event) {
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
        alert('Erreur lors de la modification du projet.');
    }
    })
        .catch(error => console.error('Erreur:', error));
    });

</script>
<script>
    document.querySelector('.add-team-member').addEventListener('click', function() {
        // Trouver le conteneur des membres de l'équipe
        const container = document.getElementById('team-members-container');

        // Compteur pour les champs supplémentaires
        const currentMemberCount = container.querySelectorAll('input').length;

        // Créer un nouvel élément input
        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = `team_members[]`;
        newInput.id = `team_members_${currentMemberCount + 1}`;
        newInput.classList.add('form-control', 'mb-2');
        newInput.placeholder = "Membre de l'équipe";

        // Ajouter le nouvel input au conteneur
        container.appendChild(newInput);
    });


</script>
</body>
</html>
