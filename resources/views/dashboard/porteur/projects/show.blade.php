@extends('layouts.app')

@section('title', 'Détails du Projet - ' . $project->title)

@section('content')
    <div class="content-body" style="width: 100%; margin: 0; padding: 0;">
        <div class="container-fluid p-0 w-100" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Détails du Projet : {{ $project->title }}</h1>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" style="background-color: #4CAF50; color: white;">
                            <h6 class="m-0 font-weight-bold">Informations du Projet</h6>
                        </div>
                        <div class="card-body">
                            <!-- Titre -->
                            <p><strong>Titre :</strong> {{ $project->title }}</p>

                            <!-- Description -->
                            <p><strong>Description :</strong> {{ $project->description }}</p>

                            <!-- Objectifs -->
                            <p><strong>Objectifs :</strong> {{ $project->objectives }}</p>

                            <!-- Budget -->
                            <p><strong>Budget :</strong> €{{ number_format($project->budget, 2, ',', ' ') }}</p>

                            <!-- Secteur d'activité -->
                            <p><strong>Secteur d'activité :</strong> {{ ucfirst($project->sector) }}</p>

                            <!-- Statut -->
                            <p><strong>Statut :</strong>
                                @if ($project->status === 'en cours')
                                    <span class="badge badge-primary">En cours</span>
                                @elseif ($project->status === 'à venir')
                                    <span class="badge badge-warning">À venir</span>
                                @elseif ($project->status === 'terminé')
                                    <span class="badge badge-success">Terminé</span>
                                @else
                                    <span class="badge badge-danger">Annulé</span>
                                @endif
                            </p>

                            <!-- Date de début prévue -->
                            <p><strong>Date de début prévue :</strong> {{ $project->start_date ? : 'Non définie' }}</p>

                            <!-- Partenaires -->
                            <p><strong>Partenaires :</strong> {{ $project->partners ?? 'Aucun partenaire spécifié' }}</p>

                            <!-- Membres de l'équipe -->
                            <p><strong>Membres de l'équipe :</strong></p>
                            <ul>
                                @if ($project->team_members)
                                    @foreach (json_decode($project->team_members, true) as $member)
                                        <li>{{ $member }}</li>
                                    @endforeach
                                @else
                                    <li>Aucun membre spécifié</li>
                                @endif
                            </ul>

                            <!-- Risques anticipés -->
                            <p><strong>Risques anticipés :</strong> {{ $project->risks ?? 'Aucun risque spécifié' }}</p>

                            <!-- Documents associés -->
                            <p><strong>Documents associés :</strong></p>
                            <ul>
                                @if($project->documents)
                                    @foreach(json_decode($project->documents, true) as $document)
                                        <a href="{{ asset('storage/' . $document) }}" target="_blank">Voir le fichier</a>
                                        <a href="{{ asset('storage/' . $document) }}" download>Télécharger</a>
                                    @endforeach
                                @else
                                    <p>Aucun document associé à ce projet.</p>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
