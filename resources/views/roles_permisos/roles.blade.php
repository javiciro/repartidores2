@extends('adminlte::page')

@section('title', 'Roles')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* Fondo gris claro */
    }

    .card-header h3 {
        font-size: 28px;
        color: #1285AD; /* Azul Claro 2 */
        text-transform: uppercase;
    }

    .card-header a.btn-success {
        background-color: #FABC0B; /* Amarillo */
        color: #fff;
        font-weight: bold;
        font-size: 18px;
        margin-left: 10px;
    }

    .table {
        background-color: #ffffff; /* Blanco */
    }

    .table th,
    .table td {
        font-size: 16px;
        color: #333; /* Texto oscuro para mejor legibilidad */
    }

    .font-size-large {
        font-size: 18px;
    }

    .empty-row {
        text-align: center;
        font-weight: bold;
        color: #777;
    }

    .custom-bg-white {
        background-color: #ffffff;
        border-bottom: 1px solid #dee2e6;
    }

    .btn-primary,
    .btn-warning,
    .btn-danger {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #1285AD; /* Azul Claro 2 */
        border-color: #1285AD; /* Azul Claro 2 */
    }

    .btn-primary:hover {
        background-color: #1197D4; /* Azul Claro */
        border-color: #1197D4; /* Azul Claro */
    }

    .btn-warning {
        background-color: #FABC0B; /* Amarillo */
        border-color: #FABC0B; /* Amarillo */
    }

    .btn-warning:hover {
        background-color: #DAA509; /* Amarillo más oscuro */
        border-color: #DAA509; /* Amarillo más oscuro */
    }

    .btn-danger {
        background-color: #E74C3C;
        border-color: #E74C3C;
    }

    .btn-danger:hover {
        background-color: #C23C2B;
        border-color: #C23C2B;
    }

    /* Modificaciones para mejorar la visibilidad y atractivo */
    .card-body {
        padding: 20px;
    }

    .table th,
    .table td {
        text-align: center;
        padding: 12px;
    }

    .btn-success {
        margin-top: 10px;
    }

</style>

<div class="container main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white custom-bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Gestión de Roles</h3>
                        <a href="{{ route('roles.create') }}" class="btn btn-success">Agregar Rol</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($roles->isEmpty())
                            <p class="empty-row">No hay roles registrados.</p>
                        @else
                            <table class="table table-bordered table-striped table-white">
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
                                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                    
                                                    @can('eliminar_rol')
                                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este rol?')">Eliminar</button>
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
    $(document).ready(function () {
        $(".table-row").hover(function () {
            $(this).css("cursor", "pointer");
        });

        $(".table-row").click(function () {
            window.location = $(this).data("href");
        });
    });
</script>
@endsection
