@extends('layouts.app')

@section('title', 'Documents Partagés - Plateforme incubation')

@section('content')
<!-- CSS inclus -->
<link rel="stylesheet" href="{{ asset('css/feather.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('documents.create') }}" class="btn btn-sm btn-primary">Ajouter un Document</a>
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
                    <button class="btn btn-primary mt-2 toggle-files" data-target="#received-documents">Ouvrir</button>
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
                    <button class="btn btn-primary mt-2 toggle-files" data-target="#sent-documents">Ouvrir</button>
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
                                    <p class="text-muted mb-0">Date de création : {{ $document->created_at->format('d M Y') }}</p>
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
                                    <p class="text-muted mb-0">Date de création : {{ $document->created_at->format('d M Y') }}</p>
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
