@extends('adminlte::page')

@section('content')
<link rel="stylesheet"  href="{{ asset('css/editClientes.css') }}">
<div class="container animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title animate__animated animate__fadeIn">
                        <span class="text-primary">Editar Datos del Cliente</span>
                        <i class="fas fa-edit" style="font-size: 24px; margin-left: 10px;"></i>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            
                <div class="card-body">
                    <form method="POST" action="{{ route('conductores.update', $cliente->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cc">CC</label>
                                    <input type="text" name="cc" id="cc" class="form-control" value="{{ $cliente->cc }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_factura">Número de Factura</label>
                                    <input type="text" name="numero_factura" id="numero_factura" class="form-control" value="{{ $cliente->numero_factura }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cliente_nombre">Nombre del Cliente</label>
                                    <input type="text" name="cliente_nombre" id="cliente_nombre" class="form-control" value="{{ $cliente->cliente_nombre }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input type="text" name="observacion" id="observacion" class="form-control" value="{{ $cliente->observacion }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="valor">Valor (COP)</label>
                                    <input type="text" name="valor" id="valor" class="form-control" value="{{ $cliente->valor }}" onblur="formatNumber(this)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="correo_cliente">Correo Cliente</label>
                                    <input type="email" name="correo_cliente" id="correo_cliente" class="form-control" value="{{ $cliente->correo_cliente }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion_cliente">Dirección Cliente</label>
                                    <input type="text" name="direccion_cliente" id="direccion_cliente" class="form-control" value="{{ $cliente->direccion_cliente }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono_cliente">Teléfono Cliente</label>
                                    <input type="number" name="telefono_cliente" id="telefono_cliente" class="form-control" value="{{ $cliente->telefono_cliente }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add input animation
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
            input.classList.add('animate__animated');
            input.classList.add('animate__shakeX');
        });
        input.addEventListener('blur', () => {
            if (input.value === '') {
                input.parentElement.classList.remove('focused');
                input.classList.remove('animate__animated');
                input.classList.remove('animate__shakeX');
            }
        });
    });

    const money = document.querySelector('#valor');
let oldValue = money.value; // Almacenar el valor anterior

money.addEventListener('input', () => {
    // Verificar si el nuevo valor tiene más dígitos que el valor anterior
    if (money.value.length > oldValue.length) {
        money.value = formatNumber(money.value);
    }
    oldValue = money.value; // Actualizar el valor anterior
});

money.addEventListener('blur', () => {
    money.value = formatNumber(money.value);
});



    function formatNumber(input) {
        // Remove non-numeric characters
        let numericValue = input.replace(/\D/g, '');

        // Check if the result is a valid number
        if (!isNaN(numericValue)) {
            // Format the number with commas for thousands
            return Number(numericValue).toLocaleString('es-CO');
        } else {
            // Handle the case where the input is not a valid number (e.g., contains non-numeric characters)
            return '';
        }
    }
</script>

@endsection