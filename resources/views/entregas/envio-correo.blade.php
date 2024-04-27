<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    <link rel="stylesheet"  href="{{ asset('css/envioCorreo.css') }}">

</head>

<body>
    <div style="max-width: 150px; width: 100%; margin: 0 auto;">
        <img src="{{ asset('imagenes/logo.jpg') }}" alt="Logo de la empresa" style="max-width: 100%; height: auto; display: block;">
    </div>
    
    <div class="container">
        <div class="card cart">
            
            <div class="steps">
                <div class="step">
                    <div>
                        <span>RECIBO PROVISIONAL UNIVERSAL.</span>
                        <p>Cliente/Empresa: {{ $cliente->cliente_nombre }}</p>
                        <p>Teléfono: {{ $cliente->telefono_cliente }}</p>
                        <p>Correo: {{ $cliente->correo_cliente }}</p>
                    </div>
                    <hr>
                    <div>
                        <span>DETALLES DE FACTURA.</span>
                        <p>Fecha de Creación: {{ $cliente->created_at }}</p>
                        <p>Número de Orden: {{ $cliente->num_factura }}</p>
                        <p>Número de Factura: {{ $cliente->numero_factura }}</p>
                    </div>
                    <hr>
                    <div class="promo">
                        <span>OBSERVACIONES</span>
                        <form class="form">
                            <p>{{ $cliente->observacion ? $cliente->observacion : 'Sin observaciones.' }}</p>
                        </form>
                    </div>
                    <hr>
                    <div class="payments">
                        <span>INFORMACIÓN PAPELERÍA UNIVERSAL.</span>
                        <div class="details">
                            <span>Número de Teléfono: 889 11 90</span>
                            <span>Dirección: Cra 9 11-04</span>
                            <span>Punto de Venta: Centro </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card checkout">
            <div class="footer">
                <label class="price">TOTAL DEL PEDIDO: ${{ number_format($cliente->valor, 0, '.', ',') }}</label>
            </div>
        </div>
    </div>
</body>

</html>
