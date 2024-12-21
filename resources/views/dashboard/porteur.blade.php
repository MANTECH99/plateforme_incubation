<!-- index.blade.php dans views -->
@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')


<!-- Progression Globale du Projet -->
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        Progression Globale des Projets
    </div>
    <div class="card-body">
        <canvas id="progressChart" width="10" height="2"></canvas>
    </div>
</div>

<div class="row">
  <!-- Autres cartes existantes -->

  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <div class="card-header bg-primary text-white">
        Statistiques globales des Taches
    </div>
        <canvas id="barChart" width="5" height="2"></canvas>

      </div>
    </div>
  </div>
  <!-- Calendrier des Séances de Mentorat -->
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="card-header bg-primary text-white">
        Calendrier des Séances de Mentorat
    </div>
        </div>
        <div class="card-body">
          <!-- Calendrier -->
          <div id="calendar" style="margin-bottom: 30px;"></div>
        </div>
      </div>
    </div>
  </div>


<!-- Inclure Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Récupérer les données des projets
        const projectTitles = @json($projects->pluck('title'));
        const projectProgress = @json($projects->map(fn($p) => $p->tasks->count() > 0 ? round($p->tasks->sum('progress') / $p->tasks->count()) : 0));
        const projectStatuses = @json($projects->map(fn($p) => 
            $p->tasks->every(fn($task) => $task->status === 'terminé') ? 'terminé' :
            ($p->tasks->some(fn($task) => $task->status === 'en cours') ? 'en cours' : 'en attente')
        ));

        const ctx = document.getElementById('progressChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar', // Type de graphique : barres verticales
            data: {
                labels: projectTitles, // Titres des projets
                datasets: [{
                    label: 'Progression des Projets (%)',
                    data: projectProgress, // Progression en pourcentage
                    backgroundColor: projectProgress.map(progress => {
                        if (progress === 100) return 'rgba(40, 167, 69, 0.3)'; // Vert clair transparent pour 100%
                        if (progress >= 50) return 'rgba(23, 162, 184, 0.3)'; // Bleu clair transparent pour >= 50%
                        return 'rgba(220, 53, 69, 0.3)'; // Rouge clair transparent pour < 50%
                    }),
                    borderColor: projectProgress.map(progress => {
                        if (progress === 100) return 'rgba(40, 167, 69, 1)'; // Vert pour 100%
                        if (progress >= 50) return 'rgba(23, 162, 184, 1)'; // Bleu pour >= 50%
                        return 'rgba(220, 53, 69, 1)'; // Rouge pour < 50%
                    }),
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
                            stepSize: 20 // Intervalles sur l'axe Y
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `Progression : ${context.raw}%`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const taskStats = @json($taskStats);

    const ctx = document.getElementById('barChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['En attente', 'Soumis', 'Non accompli'],
        datasets: [{
          label: 'Nombre de tâches',
          data: [taskStats.en_attente, taskStats.soumis, taskStats.non_accompli],
          backgroundColor: [
            'rgba(255, 193, 7, 0.3)',  // Jaune clair
            'rgba(40, 167, 69, 0.3)',  // Vert clair
            'rgba(220, 53, 69, 0.3)'   // Rouge clair
          ],
          borderColor: [
            'rgba(255, 193, 7, 1)', 
            'rgba(40, 167, 69, 1)', 
            'rgba(220, 53, 69, 1)' 
          ],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true
          }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: 'Statut des tâches'
            },
            ticks: {
              color: '#333'
            },
            // Ajuste l'espacement des barres
            barPercentage: 0.1, // Réduit la largeur de chaque barre
            categoryPercentage: 0.6 // Ajuste l'espacement entre les groupes
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Nombre de tâches'
            },
            ticks: {
              color: '#333'
            }
          }
        }
      }
    });
  });
</script>





            <!-- #/ container -->
        </div>
        <!-- JS spécifique -->
@vite('resources/js/mentorship_calendar.js')
@endsection
