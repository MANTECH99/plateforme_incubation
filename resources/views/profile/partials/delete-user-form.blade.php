<section>
    <h6 class="mb-3">
        Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.
        Téléchargez les données ou informations que vous souhaitez conserver avant de continuer.
    </h6>

    <!-- Bouton pour déclencher la modal -->
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        Supprimer le Compte
    </button>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmer la Suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer votre compte ? Veuillez entrer votre mot de passe pour confirmer.</p>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de Passe</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe">
                            @error('password')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
