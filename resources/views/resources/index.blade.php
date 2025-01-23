@extends('layouts.app')

@section('title', 'Centre de Ressources - Plateforme incubation')

@section('content')
<!-- CSS inclus -->
<link rel="stylesheet" href="{{ asset('css/feather.css') }}">
<link rel="stylesheet" href="{{ asset('css/app-light.css.css') }}" id="lightTheme">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
@if(auth()->user()->role->name == 'admin')
<!-- Bouton pour ajouter une ressource -->
<!-- Bouton pour ouvrir le modal -->
<div class="d-flex align-items-center">
    <button type="button" class="btn btn-md" style="background-color: #27ae60; color: white;" data-bs-toggle="modal" data-bs-target="#addResourceModal">
        Ajouter une Ressource
    </button>&nbsp;&nbsp;
    <input type="text" class="form-control me-2" placeholder="Rechercher une ressource..." style="width: 250px;">
</div>

@endif
<div class="container mt-4">
    <!-- Section des Dossiers -->
    <div class="row">
        <h2 class="text-center mb-4">Centre de Ressources</h2>

        <!-- Dossier: Documents & Bibliothèque -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="circle circle-md bg-secondary mx-auto">
                    <i class="fe fe-folder fe-32 text-white"></i>
                    </div>
                    <h5 class="mt-3">Documents & Bibliothèque</h5>
                    <button class="btn btn-success mt-2 toggle-files" style="background-color: #27ae60     ; color: white;" data-target="#documents-section">Ouvrir</button>
                </div>
            </div>
        </div>

        <!-- Dossier: Formations en ligne -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="circle circle-md bg-secondary mx-auto">
                        <i class="fe fe-folder fe-32 text-white"></i>
                    </div>
                    <h5 class="mt-3">Formations en ligne</h5>
                    <button class="btn btn-success mt-2 toggle-files" style="background-color: #27ae60     ; color: white;" data-target="#formations-section">Ouvrir</button>
                </div>
            </div>
        </div>

        <!-- Dossier: Outils Pratiques -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="circle circle-md bg-secondary mx-auto">
                        <i class="fe fe-folder fe-32 text-white"></i>
                    </div>
                    <h5 class="mt-3">Outils Pratiques</h5>
                    <button class="btn btn-success mt-2 toggle-files" style="background-color: #27ae60     ; color: white;" data-target="#tools-section">Ouvrir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des Fichiers -->
<!-- Documents -->
<div id="documents-section" class="file-list mt-5 d-none">
    <h3 class="mb-4"><i class="fe fe-file-text"></i> Documents & Bibliothèque</h3>
    <div class="row">
        @forelse ($documents as $document)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fe fe-file fe-32 text-primary"></i>
                            <div class="ml-3">
                                <strong>Titre : {{ $document->title }}</strong><br />
                                <p class="text-muted mb-0">Description : {{ $document->description }}</p>
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

                            <a href="{{ route('resources.download', $document->id) }}" class="btn btn-sm btn-primary">Télécharger</a>
                            {{-- Lien pour supprimer la ressource, uniquement visible pour l'administrateur --}}
                            @if(auth()->user()->role->name == 'admin')   
    <form action="{{ route('resources.destroy', $document->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')">Supprimer</button>
    </form>
@endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Aucune ressource disponible dans cette catégorie.</p>
            </div>
        @endforelse
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $documents->links('pagination::bootstrap-4') }}
    </div>
</div>


    <!-- Formations -->
    <div id="formations-section" class="file-list mt-5 d-none">
    <h3 class="mb-4"><i class="fe fe-book"></i> Formations en ligne</h3>
    <div class="row">
        @forelse ($formations as $formation)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fe fe-file fe-32 text-primary"></i>
                            <div class="ml-3">
                                <strong> Titre : {{ $formation->title }}</strong><br />
                                <p class="text-muted mb-0"> Description : {{ $formation->description }}</p>
                                <p class="text-muted mb-0">Date de création : {{ $formation->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                        @if (in_array(pathinfo($formation->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <a href="{{ asset('storage/' . $formation->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir l'image</a>
                            @elseif (pathinfo($formation->file_path, PATHINFO_EXTENSION) == 'pdf')
                                <a href="{{ asset('storage/' . $formation->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir le PDF</a>
                            @else
                                <p class="text-muted">Aperçu non disponible pour ce type de fichier.</p>
                            @endif

                            <a href="{{ route('resources.download', $formation->id) }}" class="btn btn-sm btn-primary">Télécharger</a>
                            {{-- Lien pour supprimer la ressource, uniquement visible pour l'administrateur --}}
                            @if(auth()->user()->role->name == 'admin')   
    <form action="{{ route('resources.destroy', $formation->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')">Supprimer</button>
    </form>
@endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Aucune ressource disponible dans cette catégorie.</p>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $formations->links('pagination::bootstrap-4') }}
    </div>
</div>

    <!-- Outils -->
    <div id="tools-section" class="file-list mt-5 d-none">
    <h3 class="mb-4"><i class="fe fe-tool"></i> Outils Pratiques</h3>
    <div class="row">
        @forelse ($tools as $tool)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fe fe-file fe-32 text-primary"></i>
                            <div class="ml-3">
                                <strong> Titre : {{ $tool->title }}</strong><br />
                                <p class="text-muted mb-0"> Description : {{ $tool->description }}</p>
                                <p class="text-muted mb-0">Date de création : {{ $tool->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                        @if (in_array(pathinfo($tool->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <a href="{{ asset('storage/' . $tool->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir l'image</a>
                            @elseif (pathinfo($tool->file_path, PATHINFO_EXTENSION) == 'pdf')
                                <a href="{{ asset('storage/' . $tool->file_path) }}" class="btn btn-sm btn-secondary" target="_blank">Voir le PDF</a>
                            @else
                                <p class="text-muted">Aperçu non disponible pour ce type de fichier.</p>
                            @endif

                            <a href="{{ route('resources.download', $tool->id) }}" class="btn btn-sm btn-primary">Télécharger</a>
                            {{-- Lien pour supprimer la ressource, uniquement visible pour l'administrateur --}}
                            @if(auth()->user()->role->name == 'admin')   
    <form action="{{ route('resources.destroy', $tool->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')">Supprimer</button>
    </form>
@endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Aucune ressource disponible dans cette catégorie.</p>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $tools->links('pagination::bootstrap-4') }}
    </div>
</div>

</div>


<!-- Modal Ajouter Ressource -->
<div class="modal fade" id="addResourceModal" tabindex="-1" aria-labelledby="addResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #27ae60;">
                <h5 class="modal-title" id="addResourceModalLabel" style="color: white;">Ajouter une Ressource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Titre :</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                                <label for="type">Type :</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="document">Document</option>
                                    <option value="formation">Formation</option>
                                    <option value="outil">Outil</option>
                                </select>
                            </div>
                    <div class="form-group mt-3">
                        <label for="description">Description :</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="file">Fichier :</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </div>
                </form>
            </div>
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
