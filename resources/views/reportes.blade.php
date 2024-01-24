@extends('adminlte::page')

@section('content')
<div class="container custom-container">
    <div class="card custom-card">
        <div class="card-header bg-white custom-card-header">
            <h2>Estadísticas</h2>
        </div>

        <div class="card-body">
            <!-- Gráfico de Valor Total Diario -->
            <div class="chart-container mt-4">
                <canvas id="valorDiarioChart"></canvas>
            </div>

            <!-- Gráfico de Valor Total Semanal -->
            <div class="chart-container mt-4">
                <canvas id="valorSemanalChart"></canvas>
            </div>

            <!-- Gráfico de Valor Total Mensual -->
            <div class="chart-container mt-4">
                <canvas id="valorMensualChart"></canvas>
            </div>

            <!-- Gráfico de Valor Total Anual -->
            <div class="chart-container mt-4">
                <canvas id="valorAnualChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Gráfico de Valor Total Diario
    var valorDiarioChart = new Chart(document.getElementById('valorDiarioChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyChartData['labels']) !!},
            datasets: [{
                label: 'Total Valor Diario',
                data: {!! json_encode($dailyChartData['values']) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Valor Total Semanal
    var valorSemanalChart = new Chart(document.getElementById('valorSemanalChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($weeklyChartData['labels']) !!},
        datasets: [{
            label: 'Total Valor Semanal',
            data: {!! json_encode($weeklyChartData['values']) !!},
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

    // Gráfico de Valor Total Mensual
    var valorMensualChart = new Chart(document.getElementById('valorMensualChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyChartData['labels']) !!},
            datasets: [{
                label: 'Total Valor Mensual',
                data: {!! json_encode($monthlyChartData['values']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Valor Total Anual
    var valorAnualChart = new Chart(document.getElementById('valorAnualChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($yearlyChartData['labels']) !!},
            datasets: [{
                label: 'Total Valor Anual',
                data: {!! json_encode($yearlyChartData['values']) !!},
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
