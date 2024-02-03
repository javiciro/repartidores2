@extends('adminlte::page')

@section('content')
<style>.input {
    max-width: 700px; /* Adjust the width as needed */
    height: 44px;
    background-color: #05060f0a;
    border-radius: .5rem;
    padding: 0 1rem;
    border: 2px solid transparent;
    font-size: 1rem;
    transition: border-color .3s cubic-bezier(.25,.01,.25,1) 0s, color .3s cubic-bezier(.25,.01,.25,1) 0s,background .2s cubic-bezier(.25,.01,.25,1) 0s;
  }
.label {
  display: block;
  margin-bottom: .3rem;
  font-size: .9rem;
  font-weight: bold;
  color: #05060f99;
  transition: color .3s cubic-bezier(.25,.01,.25,1) 0s;
}

.input:hover, .input:focus, .input-group:hover .input {
  outline: none;
  border-color: #05060f;
}

.input-group:hover .label, .input:focus {
  color: #05060fc2;
}
.btn:link,
.btn:visited {
 text-transform: uppercase;
 text-decoration: none;
 color: rgb(27, 27, 27);
 padding: 10px 30px;
 border: 1px solid;
 border-radius: 1000px;
 display: inline-block;
 transition: all .2s;
 position: relative;
}

.btn:hover {
 transform: translateY(-5px);
 box-shadow: 0 10px 20px rgba(27, 27, 27, .5);
}

.btn:active {
 transform: translateY(-3px);
}

.btn::after {
 content: "";
 display: inline-block;
 height: 100%;
 width: 100%;
 border-radius: 100px;
 top: 0;
 left: 0;
 position: absolute;
 z-index: -1;
 transition: all .3s;
}

.btn:hover::after {
 background-color: rgb(0, 238, 255);
 transform: scaleX(1.4) scaleY(1.5);
 opacity: 0;
}
body {
            background-color: #ffffff; /* Blanco */
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        .custom-card-header {
            background-color: #1285AD; /* Azul claro 2 */
            padding: 20px;
            color: #fabc0b; /* Blanco */
            text-align: center;
            transition: background-color 0.5s ease; /* Transición de color de fondo */
        }

        .custom-card-header:hover {
            background-color: #1197D4; /* Cambia a Azul claro al pasar el mouse */
        }

        .custom-header-text {
            margin: 0;
            font-size: 2em;
            color: #fffffe; /* Amarillo */
            transition: color 0.5s ease; /* Transición de color del texto */
        }

        .custom-card-header:hover .custom-header-text {
            color: #ffffff; /* Cambia a blanco al pasar el mouse */
        }
</style>
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="custom-card-header">
                        <h2 class="custom-header-text">Registrar Nuevo Cliente</h2>
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
                                <label class="label" for="num_placa">Seleccione Placa del Vehiculo:</label>
                                <div class="input-group">
                                    <select name="num_placa" class="input form-control" required onchange="evitarRecargaFormulario()">
                                        <option value="" disabled selected>Seleccione </option>
                                        @foreach($placas as $placa)
                                            <option value="{{ $placa->placa }}" {{ old('num_placa') == $placa->placa ? 'selected' : '' }}>
                                                {{ $placa->placa }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="label" for="cliente_nombre">Nombre del Cliente o Empresa:</label>
                                <div class="input-group">
                                    <input type="text" name="cliente_nombre" class="input form-control" value="{{ old('cliente_nombre') }}" required>
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="label" for="cc">Documento o Cédula:</label>
                                <div class="input-group">
                                    <input type="text" name="cc" class="input form-control" value="{{ old('cc') }}" required>
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="label" for="numero_factura">Número De Factura:</label>
                                <div class="input-group">
                                    <input type="text" name="numero_factura" class="input form-control">
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="label" for="observacion">Observación:</label>
                                <div class="input-group">
                                    <textarea name="observacion" class="input form-control" rows="3"></textarea>
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="label" for="valor">Valor (COP):</label>
                                <div class="input-group">
                                    <input type="text" name="valor" class="input form-control" oninput="formatNumber(this)" required>
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="label" for="num_factura">Número De recibo provisional:</label>
                                <div class="input-group">
                                    <input type="text" name="num_factura" class="input form-control" value="{{ $numFactura }}" readonly>
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="label" for="correo_cliente">Correo del Cliente:</label>
                                <div class="input-group">
                                    <input type="email" name="correo_cliente" class="input form-control" required>
                                    <div></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="direccion_cliente">Dirección del Cliente:</label>
                                <input type="text" name="direccion_cliente" class="form-control">
                                                                </div>
                            
                            <div class="form-group">
                                <label class="label" for="telefono_cliente">Teléfono del Cliente:</label>
                                <div class="input-group">
                                    <input type="tel" name="telefono_cliente" class="input form-control">
                                    <div></div>
                                </div>
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
