@extends('adminlte::page')


@section('content')
<style>
    /* Agrega tus estilos personalizados aquí */
    #btnUsuario {
        /* Estilos para el botón */
        background-color: #1285AD;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 15px;
    }

    #container-stars {
        /* Estilos para el contenedor de estrellas */
        margin-top: 10px;
    }

    #stars {
        /* Estilos para las estrellas */
        width: 100px;
        height: 20px;
        background: url('path-to-your-star-image.png') repeat-x;
    }

    #glow {
        /* Estilos para el efecto de resplandor */
        margin-top: 10px;
    }

    .circle {
        /* Estilos para el resplandor circular */
        width: 10px;
        height: 10px;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        animation: glow 1.5s ease-in-out infinite alternate;
    }

    @keyframes glow {
        /* Animación para el resplandor */
        0% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    .card-header-bg {
        background-color: #1285AD;
        color: #fff;
    }

    .btn-update-roles {
        background-color: #FABC0B;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 18px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header card-header-bg">
            <h2 class="text-center mb-0">Detalles del Usuario</h2>
            <button class="btn btn-lg btn-block mt-3" type="button" id="btnUsuario">
                <strong>{{ $user->name }}</strong>
                <div id="container-stars">
                    <div id="stars"></div>
                </div>
                <div id="glow">
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
            </button>
        </div>
    </div>

    <div class="card mt-4 shadow">
        <div class="card-body">
            <h2 class="text-center mb-4">Detalles de Usuarios y Roles</h2>

            <form action="{{ route('asignar.update', $user) }}" method="post">
                @csrf
                @method('put')
                <div class="row">
                    @foreach($roles as $role)
                        <div class="col-md-4 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="custom-control-input" id="role_{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-primary" for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-update-roles">Actualizar Roles</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
