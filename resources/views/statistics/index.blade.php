<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports et Statistiques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center text-success mb-4">Rapports et Statistiques</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total des Projets</h5>
                    <p class="card-text h3">{{ $totalProjects }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Projets Terminés</h5>
                    <p class="card-text h3">{{ $completedProjects }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Projets En Cours</h5>
                    <p class="card-text h3">{{ $ongoingProjects }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Projets Créés par Mois
                </div>
                <div class="card-body">
                    <canvas id="projectsByMonthChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    Tâches en Retard
                </div>
                <div class="card-body">
                    <h5 class="text-danger">{{ $overdueTasks }}</h5>
                </div>
            </div>
        </div>
    </div>




    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ route('statistics.export.pdf') }}" class="btn btn-danger me-2">Exporter en PDF</a>
        <a href="{{ route('statistics.export.excel') }}" class="btn btn-success">Exporter en Excel</a>
    </div>
</div>

<script>
    const ctx = document.getElementById('projectsByMonthChart').getContext('2d');
    const projectsByMonthChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyProjects->pluck('month')) !!},
            datasets: [{
                label: 'Projets par Mois',
                data: {!! json_encode($monthlyProjects->pluck('count')) !!},
                backgroundColor: 'rgba(39, 174, 96, 0.5)',
                borderColor: 'rgba(39, 174, 96, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
