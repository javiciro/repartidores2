@extends('adminlte::page')

@section('title', 'Roles y Permisos')

@section('content_header')
    <h1 class="text-bold" style="color: #007bff;">Asigna el permiso que tendrá cada rol <i class="fas fa-lock"></i></h1>
    <p class="text-muted">Selecciona el acceso a las funcionalidades del sistema.</p>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i> Recuerda que los permisos asignados afectarán la experiencia del usuario en el sistema.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{ $role->name }} <i class="fas fa-cog fa-spin"></i></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-3">Lista de Permisos <i class="fas fa-list"></i></h5>
                                <form action="{{ route('roles.update', $role) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        @foreach ($permisos as $permiso)
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="permiso_{{ $permiso->id }}" name="permisos[]" value="{{ $permiso->id }}" {{ in_array($permiso->name, $role->getPermissionNames()->toArray())? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="permiso_{{ $permiso->id }}">{{ $permiso->name }}</label>
                                                    <span class="text-muted">{{ $permiso->description }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3 btn-block">Asignar Permisos <i class="fas fa-save"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animación de carga -->
        <div class="overlay" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
    </div>

@endsection

@section('css')
    <style>
       .animated {
            animation-duration: 0.5s;
        }
       .fadeIn {
            animation-name: fadeIn;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Estilos adicionales para mejorar la apariencia */
       .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
       .card-header {
            background-color: #f7f7f7;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
       .card-body {
            padding: 20px;
        }
       .custom-control {
            margin-bottom: 10px;
        }
       .custom-control-label {
            font-weight: bold;
        }
       .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
       .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0069d9;
        }
       .alert {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Animación de carga
            $('.overlay').fadeIn(500);
            setTimeout(function() {
                $('.overlay').fadeOut(500);
            }, 2000);
        });
    </script>
@endsection