@extends('adminlte::page')

@section('title', 'Estadisticas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="valorDiarioChart" class="chart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="valorSemanalChart" class="chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="valorMensualChart" class="chart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="valorAnualChart" class="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Función para configurar opciones comunes a todos los gráficos
    function configureChartOptions() {
        return {
            responsive: true, // Hace que el gráfico sea responsivo
            maintainAspectRatio: false, // Permite ajustar el aspect ratio
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };
    }

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
        options: configureChartOptions()
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
        options: configureChartOptions()
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
        options: configureChartOptions()
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
        options: configureChartOptions()
    });
</script>
@endsection
