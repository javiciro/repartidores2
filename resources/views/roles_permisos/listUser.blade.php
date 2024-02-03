@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <style>
        body {
            background-color: #f8f9fa; /* Light gray background color */
        }

        .card {
            border-radius: 15px;
            border: 1px solid #dee2e6;
            margin-top: 20px;
        }

        .card-header {
            background-color: #1285AD;
            border-radius: 15px 15px 0 0;
            padding: 15px;
            color: #fff;
            text-align: center;
        }

        .card-title {
            font-size: 24px;
            margin-bottom: 0;
        }

        .card-body {
            padding: 20px;
        }

        .table {
            background-color: #ffffff; /* White background color */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            font-size: 16px;
            text-align: center;
        }

        .btn-group {
            display: flex;
            justify-content: center;
        }

        .btn {
            border-radius: 5px;
            margin: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-warning {
            background-color: #FABC0B;
            color: #fff;
            border: 1px solid #FABC0B;
        }

        .btn-danger {
            background-color: #DC3545;
            color: #fff;
            border: 1px solid #DC3545;
        }

        .btn-secondary {
            background-color: #6C757D;
            color: #fff;
            border: 1px solid #6C757D;
        }

        .empty-row {
            text-align: center;
            font-weight: bold;
            color: #777;
        }

        .card-footer {
            background-color: #ffffff;
            border-radius: 0 0 15px 15px;
            padding: 15px;
        }
    </style>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Administración de Usuarios</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Table to display users -->
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('asignar.edit', $user->id) }}" class="btn btn-warning">Editar</a>

                                                    {{-- Verificar si el usuario tiene el rol "admin" --}}

                                                    <form action="{{ route('asignar.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">Eliminar</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center empty-row">No hay usuarios registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
