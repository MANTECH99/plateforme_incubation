@extends('layouts.app')

@section('title', 'Détails du Projet - ' . $project->title)

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h4 class="text-success" style="color: #27ae60;"><i class="bi bi-info-circle"></i> Détails du projet : {{ $project->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <!-- Date de début prévue -->
                                <div class="col-12 col-sm-4 mb-4">
                                    <div class="card shadow-sm" style="border: 2px solid rgba(40, 167, 69, 0.5); border-radius: 10px;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-muted">
                                                <i class="bi bi-calendar-event"></i> Date de début prévue
                                            </h5>
                                            <p class="card-text text-success h4" style="color: #27ae60;">
                                                {{ $project->start_date ?? 'Non définie' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Budget estimé -->
                                <div class="col-12 col-sm-4 mb-4">
                                    <div class="card shadow-sm" style="border: 2px solid rgba(40, 167, 69, 0.5); border-radius: 10px;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-muted">

                                                <i class="fas fa-dollar-sign"></i> Budget estimé





                                            </h5>
                                            <p class="card-text text-success h4" style="color: #27ae60;">
                                                {{ number_format($project->budget) }} FCFA
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Secteur d'activité -->
                                <div class="col-12 col-sm-4 mb-4">
                                    <div class="card shadow-sm" style="border: 2px solid rgba(40, 167, 69, 0.5); border-radius: 10px;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-muted">
                                                <i class="bi bi-briefcase"></i> Secteur d'activité
                                            </h5>
                                            <p class="card-text text-success h4">
                                                {{ ucfirst($project->sector) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-success"><i class="bi bi-flag"></i> Objectifs</h4>
                                    <p>{{ $project->objectives }}</p><br>
                                    <h4 class="text-success"><i class="bi bi-check-circle"></i> Statut</h4>
                                    <p class="text-muted">
                                        @if ($project->status === 'en cours')
                                            <i class="bi bi-hourglass-split"></i>  <span class="badge badge-primary">En cours</span>
                                        @elseif ($project->status === 'à venir')
                                            <i class="bi bi-calendar3"></i> <span class="badge badge-warning">À venir</span>
                                        @elseif ($project->status === 'terminé')
                                            <i class="bi bi-check-circle-fill"></i> <span class="badge badge-success">Terminé</span>
                                        @else
                                            <i class="bi bi-x-circle"></i> <span class="badge badge-danger">Annulé</span>
                                        @endif
                                    </p><br>
                                    <h4 class="text-success"><i class="bi bi-exclamation-circle"></i> Risques</h4>
                                    <p>{{ $project->risks ?? 'Aucun risque spécifié' }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <h4 class="text-success"><i class="bi bi-file-text"></i> Description</h4>
                            <p >{{ $project->description }}</p>
                            <br>
                            <div class="text-muted">
                                <h4 class="text-success"><i class="bi bi-people"></i> Partenaires</h4>
                                <p class="text-lg">{{ $project->partners ?? 'Aucun partenaire spécifié' }}</p><br>
                                <h4 class="text-success"><i class="bi bi-person"></i> Membres de l'équipe</h4>
                                <p class="text-lg">
                                    @if ($project->team_members)
                                        @foreach (json_decode($project->team_members, true) as $member)
                                            <i class="bi bi-person-circle"></i> {{ $member }}<br>
                                        @endforeach
                                    @else
                                        Aucun membre spécifié
                                    @endif
                                </p>
                            </div><br>
                            <h4 class="text-success"><i class="bi bi-folder"></i> Documents associés</h4>
                            <ul class="list-unstyled">
                                @if ($project->documents)
                                    @foreach (json_decode($project->documents, true) as $document)
                                        <li>
                                            <a href="{{ asset('storage/' . $document) }}" class="btn-link text-secondary" target="_blank">
                                                <i class="bi bi-file-earmark"></i> {{ basename($document) }}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li>Aucun document associé.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
