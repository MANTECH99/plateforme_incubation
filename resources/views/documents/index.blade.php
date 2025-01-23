@extends('layouts.app')

@section('title', 'Documents Partagés - Plateforme incubation')

@section('content')
<!-- CSS inclus -->
<link rel="stylesheet" href="{{ asset('css/feather.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<div class="d-flex align-items-center">
<!-- Bouton pour afficher le modal d'ajout -->
<a href="javascript:void(0);" class="btn btn-md" style="background-color: #27ae60; color: white;" data-bs-toggle="modal" data-bs-target="#addDocumentModal">Ajouter un Document</a>
&nbsp;&nbsp;
        <input type="text" class="form-control me-2" placeholder="Rechercher un document..." style="width: 250px;">

    </div>


<!-- Modal d'ajout de document -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDocumentModalLabel">Ajouter un Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Formulaire d'ajout de document -->
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Partie gauche (Titre, Description et Fichier) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="font-weight-bold">Titre :</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="description" class="font-weight-bold">Description :</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group mt-3">
                        <label for="file" class="font-weight-bold">Fichier :</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                </div>

                <!-- Partie droite (Partager avec) -->
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="shared_with" class="font-weight-bold">Partager avec :</label>
                        <div id="shared_with_groups" class="p-3 border rounded bg-light">
                            <p class="text-muted">Sélectionnez les utilisateurs avec lesquels vous souhaitez partager le document.</p>

                            <div class="mt-3">
                                <h5>Coachs</h5>
                                <select name="shared_with[]" id="shared_with_coaches" class="form-control" multiple>
                                    @foreach ($coaches as $coach)
                                        <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-3">
                                <h5>Porteurs de Projets</h5>
                                <select name="shared_with[]" id="shared_with_porteurs" class="form-control" multiple>
                                    @foreach ($porteurs as $porteur)
                                        <option value="{{ $porteur->id }}">{{ $porteur->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Ajouter</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
    <!-- Section des Dossiers -->
    <div class="row">
        <h2 class="text-center mb-4">Documents Partagés</h2>

        <!-- Dossier: Documents Reçus -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="circle circle-md bg-secondary mx-auto">
                        <i class="fe fe-folder fe-32 text-white"></i>
                    </div>
                    <h5 class="mt-3">Documents Reçus</h5>
                    <button class="btn btn-success mt-2 toggle-files" style="background-color: #27ae60; color: white;" data-target="#received-documents">Ouvrir</button>
                </div>
            </div>
        </div>

        <!-- Dossier: Documents Envoyés -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="circle circle-md bg-secondary mx-auto">
                        <i class="fe fe-folder fe-32 text-white"></i>
                    </div>
                    <h5 class="mt-3">Documents Envoyés</h5>
                    <button class="btn btn-success mt-2 toggle-files" style="background-color: #27ae60; color: white;" data-target="#sent-documents">Ouvrir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des Fichiers -->
    <!-- Documents Reçus -->
    <div id="received-documents" class="file-list mt-5 d-none">
        <h3 class="mb-4"><i class="fe fe-download"></i> Documents Reçus</h3>
        <div class="row">
            @forelse ($receivedDocuments as $document)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="fe fe-file fe-32 text-primary"></i>
                                <div class="ml-3">
                                    <strong>Titre : {{ $document->title }}</strong><br />
                                    <p class="text-muted mb-0">Description : {{ $document->description }}</p>
                                    <p class="text-muted mb-0">Partagé par : {{ $document->uploader->name }}</p>
                                    <p class="text-muted mb-0">Date : {{ $document->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                            @if (in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir l'image</a>
                            @elseif (pathinfo($document->file_path, PATHINFO_EXTENSION) == 'pdf')
                                <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir le PDF</a>
                            @else
                                <p class="text-muted">Aperçu non disponible pour ce type de fichier.</p>
                            @endif
                                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-sm btn-primary">Télécharger</a>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#receivedDocumentModal{{ $document->id }}">Voir les détails</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal: Document Reçu -->
                <div class="modal fade" id="receivedDocumentModal{{ $document->id }}" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentModalLabel">{{ $document->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Description :</strong> {{ $document->description }}</p>
                                <p><strong>Partagé par :</strong> {{ $document->uploader->name }}</p>
                                <p><strong>Date :</strong> {{ $document->created_at->format('d M Y') }}</p>
                                @if (in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $document->file_path) }}" class="img-fluid" alt="{{ $document->title }}">
                                @elseif (pathinfo($document->file_path, PATHINFO_EXTENSION) == 'pdf')
                                    <embed src="{{ asset('storage/' . $document->file_path) }}" width="100%" height="500px" />
                                @else
                                    <p class="text-muted">Aperçu non disponible pour ce type de fichier.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-primary">Télécharger</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Aucun document reçu disponible.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Documents Envoyés -->
    <div id="sent-documents" class="file-list mt-5 d-none">
        <h3 class="mb-4"><i class="fe fe-share"></i> Documents Envoyés</h3>
        <div class="row">
            @forelse ($sentDocuments as $document)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="fe fe-file fe-32 text-primary"></i>
                                <div class="ml-3">
                                    <strong>Titre : {{ $document->title }}</strong><br />
                                    <p class="text-muted mb-0">Description : {{ $document->description }}</p>
                                    <p class="text-muted mb-0">Partagé avec : {{ $document->sharedWith->name ?? 'Non spécifié' }}</p>
                                    <p class="text-muted mb-0">Date : {{ $document->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                            @if (in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir l'image</a>
                            @elseif (pathinfo($document->file_path, PATHINFO_EXTENSION) == 'pdf')
                                <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir le PDF</a>
                            @else
                                <p class="text-muted">Aperçu non disponible pour ce type de fichier.</p>
                            @endif
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#sentDocumentModal{{ $document->id }}">Voir les détails</button>
                                @if ($document->uploaded_by === auth()->id())
                                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">Supprimer</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal: Document Envoyé -->
                <div class="modal fade" id="sentDocumentModal{{ $document->id }}" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentModalLabel">{{ $document->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Description :</strong> {{ $document->description }}</p>
                                <p><strong>Partagé avec :</strong> {{ $document->sharedWith->name ?? 'Non spécifié' }}</p>
                                <p><strong>Date :</strong> {{ $document->created_at->format('d M Y') }}</p>
                                @if (in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $document->file_path) }}" class="img-fluid" alt="{{ $document->title }}">
                                @elseif (pathinfo($document->file_path, PATHINFO_EXTENSION) == 'pdf')
                                    <embed src="{{ asset('storage/' . $document->file_path) }}" width="100%" height="500px" />
                                @else
                                    <p class="text-muted">Aperçu non disponible pour ce type de fichier.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-primary">Télécharger</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Aucun document envoyé disponible.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>




<!-- JS inclus -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.toggle-files').click(function () {
            const target = $(this).data('target');
            $('.file-list').addClass('d-none'); // Cache toutes les sections
            $(target).removeClass('d-none'); // Affiche la section cible
        });
    });
</script>
@endsection
