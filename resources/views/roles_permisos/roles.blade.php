@extends('adminlte::page')

@section('title', 'Roles')

@section('content')
<style>
    /* Variables */
    :root {
        --primary-color: #1285AD; /* Azul Claro 2 */
        --secondary-color: #FABC0B; /* Amarillo */
        --danger-color: #E74C3C;
        --success-color: #ffc402;
        --white-color: #ffffff;
        --dark-color: #333;
        --gray-color: #f8f9fa;
    }

    /* Global Styles */
    body {
        background-color: var(--gray-color);
        font-family: 'Open Sans', sans-serif;
    }

   .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

   .card-header {
        background-color: var(--primary-color);
        color: #fff;
        padding: 20px;
        border-bottom: 1px solid var(--gray-color);
    }

   .card-header h3 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

   .card-body {
        padding: 30px;
    }

   .table {
        background-color: var(--white-color);
        border-collapse: collapse;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

   .table th,
   .table td {
        text-align: center;
        padding: 15px;
        border-bottom: 1px solid var(--gray-color);
    }

   .table th {
        background-color: var(--primary-color);
        color: #fff;
    }

   .table td {
        font-size: 16px;
        color: var(--dark-color);
    }

   .btn {
        font-weight: bold;
        font-size: 16px;
        padding: 10px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

   .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

   .btn-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

   .btn-success {
        background-color: var(--success-color);
       border-color: var(--success-color);
    }

   .btn-success:hover {
        background-color: var(--success-color);
        border-color: var(--success-color);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

   .btn-warning {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

   .btn-warning:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

   .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

   .btn-danger:hover {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .loading-animation {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 9999;
    }

    .loading-animation .spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px;
        color: var(--primary-color);
        animation: rotate 2s linear infinite;
    }

    @keyframes rotate {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }
        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
</style>

<div class="container main-content">
    <div class="row">
        <div class="col-12">
            <div class="card animate">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Gestión de Roles</h3>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="loading-animation">
                            <div class="spinner">⚙️</div>
                        </div>
                        @if($roles->isEmpty())
                            <p class="empty-row">No hay roles registrados.</p>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm animate">Editar</a>
                                                    
                                                    @can('eliminar_rol')
                                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm animate" onclick="return confirm('¿Estás seguro de que quieres eliminar este rol?')">Eliminar</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No hay roles registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('.loading-animation').fadeOut();
    });
</script>
@endsection