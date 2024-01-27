@extends('adminlte::page')

@section('content')
<style>
    /* Aquí va el código CSS que proporcionaste */
    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 350px;
        background-color: #fff;
        padding: 20px;
        border-radius: 20px;
        position: relative;
    }

    .title {
        font-size: 28px;
        color: royalblue;
        font-weight: 600;
        letter-spacing: -1px;
        position: relative;
        display: flex;
        align-items: center;
        padding-left: 30px;
    }

    .title::before, .title::after {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        border-radius: 50%;
        left: 0px;
        background-color: royalblue;
    }

    .title::before {
        width: 18px;
        height: 18px;
        background-color: royalblue;
    }

    .title::after {
        width: 18px;
        height: 18px;
        animation: pulse 1s linear infinite;
    }

    .message, .signin {
        color: rgba(88, 87, 87, 0.822);
        font-size: 14px;
    }

    .signin {
        text-align: center;
    }

    .signin a {
        color: royalblue;
    }

    .signin a:hover {
        text-decoration: underline royalblue;
    }

    .flex {
        display: flex;
        width: 100%;
        gap: 6px;
    }

    .form label {
        position: relative;
    }

    .form label .input {
        width: 100%;
        padding: 10px 10px 20px 10px;
        outline: 0;
        border: 1px solid rgba(105, 105, 105, 0.397);
        border-radius: 10px;
    }

    .form label .input + span {
        position: absolute;
        left: 10px;
        top: 15px;
        color: grey;
        font-size: 0.9em;
        cursor: text;
        transition: 0.3s ease;
    }

    .form label .input:placeholder-shown + span {
        top: 15px;
        font-size: 0.9em;
    }

    .form label .input:focus + span, .form label .input:valid + span {
        top: 30px;
        font-size: 0.7em;
        font-weight: 600;
    }

    .form label .input:valid + span {
        color: green;
    }

    .submit {
        border: none;
        outline: none;
        background-color: royalblue;
        padding: 10px;
        border-radius: 10px;
        color: #fff;
        font-size: 16px;
        transform: .3s ease;
    }

    .submit:hover {
        background-color: rgb(56, 90, 194);
    }

    @keyframes pulse {
        from {
            transform: scale(0.9);
            opacity: 1;
        }

        to {
            transform: scale(1.8);
            opacity: 0;
        }
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Registrar Nuevo Cliente</h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="registroForm" action="{{ route('conductores.store') }}" method="POST" onsubmit="return validarFormulario()">
                        @csrf

                        <div class="form-group">
                            <label for="num_placa">Seleccione Placa del Vehiculo:</label>
                            <select name="num_placa" class="form-control" required onchange="evitarRecargaFormulario()">
                                <option value="" disabled selected>Seleccione </option>
                                @foreach($placas as $placa)
                                    <option value="{{ $placa->placa }}" {{ old('num_placa') == $placa->placa ? 'selected' : '' }}>
                                        {{ $placa->placa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="cliente_nombre">Nombre del Cliente o Empresa:</label>
                            <input type="text" name="cliente_nombre" class="form-control" value="{{ old('cliente_nombre') }}" required>
                            @if ($errors->has('cliente_nombre'))
                                <span class="text-danger">{{ $errors->first('cliente_nombre') }}</span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="cc">Documento o Cédula:</label>
                            <input type="text" name="cc" class="form-control" value="{{ old('cc') }}" required>
                            @if ($errors->has('cc'))
                                <span class="text-danger">{{ $errors->first('cc') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="numero_factura">Numero De Factura:</label>
                            <input type="text" name="numero_factura" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="observacion">Observación:</label>
                            <textarea name="observacion" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="valor">Valor (COP):</label>
                            <input type="text" name="valor" class="form-control" oninput="formatNumber(this)" required>
                        </div>

                        <div class="form-group">
                            <label for="num_factura">Numero De recibo provisional:</label>
                            <input type="text" name="num_factura" class="form-control" value="{{ $numFactura }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="correo_cliente">Correo del Cliente:</label>
                            <input type="email" name="correo_cliente" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="direccion_cliente">Dirección del Cliente:</label>
                            <input type="text" name="direccion_cliente" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="telefono_cliente">Teléfono del Cliente:</label>
                            <input type="tel" name="telefono_cliente" class="form-control">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="guardarBtn">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validarFormulario() {
        var clienteNombre = document.getElementsByName('cliente_nombre')[0].value;
        var valor = document.getElementsByName('valor')[0].value;
        var cc = document.getElementsByName('cc')[0].value;
        var correoCliente = document.getElementsByName('correo_cliente')[0].value;
        var telefonoCliente = document.getElementsByName('telefono_cliente')[0].value;

        // Verificar si los campos requeridos están llenos
        if (!clienteNombre || !valor || !correoCliente) {
            alert('Por favor, completa todos los campos antes de guardar.');
            return false;
        }

        // Validar que el valor sea numérico antes de enviar el formulario
        if (isNaN(parseFloat(valor))) {
            alert('El campo "Valor" debe ser un número.');
            return false;
        }

        if (isNaN(parseFloat(cc))) {
            alert('El campo "Documento o Cédula" debe ser un número.');
            return false;
        }

        // Validar que el teléfono solo contenga dígitos
        if (!/^\d+$/.test(telefonoCliente)) {
            alert('El campo "Teléfono" solo puede contener números.');
            return false;
        }

        // Desactiva el botón después de hacer clic para evitar múltiples envíos
        document.getElementById('guardarBtn').disabled = true;
        
        // Devuelve true para permitir el envío del formulario
        return true;
    }

    function evitarRecargaFormulario() {
        // Evita la recarga del formulario al cambiar el conductor
        event.preventDefault();
    }
    function formatNumber(input) {
            // Remove non-numeric characters
            let numericValue = input.value.replace(/\D/g, '');

            // Check if the result is a valid number
            if (!isNaN(numericValue)) {
                // Format the number with commas for thousands
                input.value = Number(numericValue).toLocaleString('es-CO');
            } else {
                // Handle the case where the input is not a valid number (e.g., contains non-numeric characters)
                input.value = '';
            }
        }
</script>

@endsection
