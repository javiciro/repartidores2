@extends('adminlte::page')

@section('title', 'roles y permisos')

@section('content_header')
    <h1 class="text-bold" style="color: #3c8dbc;">Roles y Permisos nnnnnnnnnnnnn</h1>
    <p class="text-muted">Asigna permisos a los roles para controlar el acceso a las funcionalidades del sistema.</p>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $role->name }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3">Lista de Permisos</h5>
                    <form action="{{ route('roles.update', $role) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row">
                            @foreach ($permisos as $permiso)
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="permiso_{{ $permiso->id }}" name="permisos[]" value="{{ $permiso->id }}" {{ in_array($permiso->name, $role->getPermissionNames()->toArray())? 'checked' : '' }}>
                                        <label class="custom-control-label" for="permiso_{{ $permiso->id }}">{{ $permiso->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Asignar Permisos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
       .custom-control-input:checked~.custom-control-label::before {
            background-color: #007bff!important;
            border-color: #007bff!important;
        }

       .custom-control-input:checked~.custom-control-label::after {
            color: #fff!important;
        }

       .btn-primary {
            background-color: #3c8dbc;
            border-color: #3c8dbc;
        }

       .btn-primary:hover {
            background-color: #3071a9;
            border-color: #3071a9;
        }

        /* Agregamos estilos para mejorar la apariencia */
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
            font-size: 16px;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script> console.log('Hi!'); </script>
@stop