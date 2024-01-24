@extends('adminlte::page')

@section('content')
<style>
    /* Card Header Styling */
    .card-header {
        background-color: #d2ae29;
        color: #ffffff;
        padding: 10px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Title Styling */
    .card-title {
        font-size: 24px;
        text-transform: uppercase;
        margin: 0;
    }

    /* "Crear Cliente" Button Styling */
    .btn-crear-cliente {
        background-color: #1398f1;
        color: #ffffff;
        font-weight: bold;
        font-size: 18px;
    }

    /* Filter Form Styling */
    .filter-form {
        margin-top: 20px;
    }

    /* Total Value Alert Styling */
    .custom-total-alert {
        background-color: #f7e1e1;
        color: #353030;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    /* Table Container Styling */
    .table-container {
        margin-top: 20px;
    }

    /* Table Header Styling */
    .table-header {
        background-color: #ecf0f1;
        font-weight: bold;
    }

    /* Alternating Row Colors */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    /* Hover Effect on Table Rows */
    .table-hover tbody tr:hover {
        background-color: #e6f7ff;
    }

    /* Pagination Styling */
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }
</style>

<div class="container-fluid main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white">Clientes Creados Universal</h3>
                
                    <!-- Formulario para crear un nuevo cliente -->
                    <a href="{{ route('conductores.create') }}" class="btn btn-primary btn-lg ml-auto btn-crear-cliente">
                        <i class="fas fa-plus-circle"></i> Crear Cliente
                    </a>
                </div>
                
                <!-- Formulario de Filtros -->
                <form method="GET" action="{{ route('conductores.index') }}" class="filter-form mt-3">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label for="fecha_creacion">Fecha Creación:</label>
                            <input type="date" class="form-control" name="fecha_creacion" value="{{ request('fecha_creacion') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="estado">Estado:</label>
                            <select class="form-control" name="estado">
                                <option value=""{{ empty(request('estado')) ? ' selected' : '' }}>Todos</option>
                                <option value="pendiente"{{ request('estado') == 'pendiente' ? ' selected' : '' }}>Pendiente</option>
                                <option value="entregado"{{ request('estado') == 'entregado' ? ' selected' : '' }}>Entregado</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="cliente_filtro">Filtrar Cliente:</label>
                            <input type="text" class="form-control" name="cliente_filtro" value="{{ request('cliente_filtro') }}">
                        </div>
                        <div class="col-md-3 mb-1" style="display: flex; align-items: center; margin-top: 0.6cm;">
                            <label class="text-white">-</label>
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                                <a href="{{ route('conductores.index') }}" class="btn btn-danger">Limpiar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="alert custom-total-alert" role="alert">
        <h4>Total Valor hecho: ${{ number_format($totalValor, 0, ',', '.') }}</h4>
    </div>

    <div class="table-responsive">
        @if($clientes->isEmpty())
            <p class="empty-row">No hay clientes creados.</p>
        @else
            <table class="table table-bordered table-striped table-white table-hover">
                <thead class="table-header">
                    <tr>
                        <!-- Ajusta los nombres de las columnas según tus modelos -->
                        <th>Estado</th>
                        <th>Nombre del Cliente</th>
                        <th>CC cliente</th>
                        <th>Orden Pro</th>
                        <th>Observación</th>
                        <th>Valor</th>
                        <th>Número de Factura</th>
                        <th>Correo del Cliente</th>
                        <th>Dirección del Cliente</th>
                        <th>Teléfono del Cliente</th>
                        <th>Fecha de Creación</th>
                        <th>Número de Placa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <!-- Ajusta los nombres de las columnas según tus modelos -->
                        <td>{{ $cliente->estado }}</td>
                        <td class="font-size-large">{{ $cliente->cliente_nombre }}</td>
                        <td>{{ $cliente->cc }}</td>
                        <td>{{ $cliente->numero_factura }}</td>
                        <td>{{ $cliente->observacion ?: 'Ninguna' }}</td>
                        <td>{{ number_format($cliente->valor, 2, '.', ',') }}</td>
                        <td>{{ $cliente->num_factura }}</td>
                        <td>{{ $cliente->correo_cliente }}</td>
                        <td>{{ $cliente->direccion_cliente }}</td>
                        <td>{{ $cliente->telefono_cliente }}</td>
                        <td>{{ $cliente->created_at->timezone('America/Bogota')->format('d-m-Y g:i A') }}</td>
                        <td>{{ $cliente->num_placa }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $clientes->links() }}
        @endif
    </div>
</div>

@endsection
