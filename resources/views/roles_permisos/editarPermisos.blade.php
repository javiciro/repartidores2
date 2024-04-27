@extends('adminlte::page')

@section('title', 'Editar Permiso')

@section('content')
<style>
    /* Variables */
    :root {
        --primary-color: #3498db; /* Azul Claro 2 */
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
        font-size: 28px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

  .card-header a.btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        font-weight: bold;
        font-size: 18px;
        padding: 10px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

  .card-header a.btn-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

  .card-body {
        padding: 30px;
    }

  .form-group {
        margin-bottom: 20px;
    }

  .form-group label {
        font-size: 16px;
        font-weight: bold;
        color: var(--dark-color);
    }

  .form-group input[type="text"] {
        border: 1px solid var(--gray-color);
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 16px;
        color: var(--dark-color);
        transition: all 0.3s ease;
    }

  .form-group input[type="text"]:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

  .btn-primary {
        font-weight: bold;
        font-size: 16px;
        padding: 10px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

  .btn-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
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

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card animate">
                <div class="card-header">
                    <h3 class="card-title">Editar Permiso</h3>
                    <div class="card-tools">
                        <a href="{{ route('permisos.index') }}" class="btn btn-primary animate">Volver</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Formulario de edición -->
                    <form action="{{ route('permisos.update', $permiso->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nombre">Nombre del Permiso:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $permiso->name }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $(".loading-animation").fadeOut();
    });
</script>

@endsection