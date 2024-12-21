@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card" style="background: linear-gradient(to right, #16A085, #1ABC9C);">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Administrateurs</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $totalAdmins }}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-2">
                <div class="card-body">
                    <h3 class="card-title text-white">Porteurs de projets</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $totalPorteurs }}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card gradient-3">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Coachs</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $totalCoachs }}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">
                                <h3 class="card-title text-white">A implémenter</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">?</h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-heart"></i></span>
                            </div>
                        </div>
                    </div>

        <!-- Sélectionner un porteur -->
        <div class="col-lg-12 mt-4">
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="form-group">
                    <label for="porteur_id">Sélectionnez un porteur de projet pour voir sa progression</label>
                    <select name="porteur_id" id="porteur_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Choisir un porteur --</option>
                        @foreach($porteurs as $porteur)
                            <option value="{{ $porteur->id }}" {{ request('porteur_id') == $porteur->id ? 'selected' : '' }}>
                                {{ $porteur->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Graphique de la progression des projets du porteur sélectionné -->
    @if ($selectedPorteurProgress && $selectedPorteurProgress->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            Progression des Projets de {{ $selectedPorteur->name }}
        </div>
        <div class="card-body" >
            <canvas id="progressChart" width="10" height="2"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const projectTitles = @json($selectedPorteurProgress->pluck('name'));
            const projectProgress = @json($selectedPorteurProgress->pluck('progress'));

            const ctx = document.getElementById('progressChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: projectTitles,
                    datasets: [{
                        label: 'Progression (%)',
                        data: projectProgress,
                        backgroundColor: '#17a2b8',
                        borderColor: '#ffffff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: { display: true, text: 'Projets' },
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: { display: true, text: 'Progression (%)' },
                            ticks: {
                                stepSize: 20
                            }
                        }
                    }
                }
            });
        });
    </script>
    @else
        <div class="alert alert-warning">Aucun projet trouvé pour le porteur sélectionné.</div>
    @endif
</div>
@endsection
