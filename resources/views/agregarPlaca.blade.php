@extends('adminlte::page')

@section('title', 'Placas')
>

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="background-color: #ffffff; border: 1px solid #1197D4;">
                    <div class="card-header" style="background-color: #1197D4; color: #ffffff;">
                        <h3 class="card-title">Agregar Placa</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ url('/agregarPlaca') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="placa">Placa:</label>
                                <input type="text" name="placa" id="placa" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #1285AD;">Guardar
                                Placa</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card" style="background-color: #ffffff; border: 1px solid #1197D4;">
                    <div class="card-header" style="background-color: #1197D4; color: #ffffff;">
                        <h3 class="card-title">Placas Creadas</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Placa</th>
                                    <th>Acciones</th> <!-- Agregar una columna para las acciones -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($placas as $placa)
                                    <tr>
                                        <td>{{ $placa->placa }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#editarPlaca{{ $placa->id }}">Editar</button>
                                            <form action="{{ route('placa.destroy', $placa->id) }}" method="post"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta placa?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal de Edición -->
                                    <div class="modal fade" id="editarPlaca{{ $placa->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editarPlaca{{ $placa->id }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarPlaca{{ $placa->id }}Label">Editar
                                                        Placa</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('placa.update', $placa->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="placa">Placa:</label>
                                                            <input type="text" name="placa" id="placa"
                                                                class="form-control" value="{{ $placa->placa }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Guardar
                                                            Cambios</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="2">No hay placas disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $placas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
