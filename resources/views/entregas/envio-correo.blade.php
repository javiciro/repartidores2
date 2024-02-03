<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        .container {
            display: grid;
            grid-template-columns: auto;
            gap: 0px;
            padding: 20px; /* Decreased padding for better spacing */
            background-color: #ffffff;
        }

        hr {
            height: 2px;
            background-color: #1285AD;
            border: none;
            margin: 10px 0; /* Increased margin for better spacing */
        }

        .card {
            width: 100%;
            max-width: 600px; /* Decreased max-width for a smaller card */
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        .title {
            height: 60px; /* Decreased height for better visibility */
            line-height: 60px;
            font-weight: 800;
            font-size: 20px; /* Decreased font size for better visibility */
            color: #1197D4;/
        }

        /* Cart */
        .cart {
            border-radius: 20px 20px 0px 0px;
        }

        .cart .steps {
            padding: 30px; /* Increased padding for better spacing */
        }

        .cart .steps .step span {
            font-size: 18px; /* Increased font size for better visibility */
            font-weight: 700; /* Increased font weight for better readability */
            color: #000000;
            margin-bottom: 12px;
            display: block;
        }

        .cart .steps .step p {
            font-size: 14px; /* Increased font size for better visibility */
            font-weight: 500; /* Slightly increased font weight */
            color: #000000;
        }

        /* Promo */
        .promo form {
            padding: 20px; /* Increased padding for better spacing */
        }

        .input_field {
            height: 50px; /* Increased height for better visibility */
            font-size: 16px; /* Increased font size for better visibility */
            border-radius: 8px;
            background-color: #FABC0B; /* Yellow background */
            color: #000000;
        }

        .input_field:focus {
            border: 1px solid transparent;
            box-shadow: 0px 0px 0px 2px #FABC0B; /* Yellow border on focus */
            background-color: #fffff; /* White background on focus */
        }

        .promo form button {
            padding: 14px 24px; /* Increased padding for better button size */
            font-size: 16px; /* Increased font size for better visibility */
            background-color: #1285AD; /* Light blue color */
            color: #ffffff; /* White text color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .promo form button:hover {
            background-color: #1197D4; /* Slightly darker shade on hover */
        }

        /* Checkout */
        .payments .details {
            padding: 20px;
        }

        .payments .details span {
            font-size: 16px; /* Increased font size for better visibility */
            font-weight: 600;
            color: #000000;
            margin: 10px 0;
        }

        .checkout .footer {
            padding: 20px;
            background-color: #1285AD; /* Light blue color */
            border-radius: 0 0 15px 15px;
        }

        .price {
            font-size: 32px; /* Increased font asize for better visibility */
            font-weight: 900;
            color: #2B2B2F;
        }

        .checkout .checkout-btn {
            height: 50px; /* Increased height for better button size */
            font-size: 18px; /* Increased font size for better visibility */
            font-weight: 700; /* Increased font weight for better readability */
            background-color: #1197D4; /* Light blue color */
            color: #ffffff; /* White text color */
            border: none;
            border-radius: 7px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .checkout .checkout-btn:hover {
            background-color: #0E6C9F; /* Slightly darker shade on hover */
        }
        .logo {
            max-width: 150px;
            height: auto;
            border-radius: 10px;/* Añade esta propiedad para manejar posibles problemas en algunos clientes de correo */
            margin: 0 auto;
        }    
    </style>
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
