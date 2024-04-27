<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

       .bg-cover {
            height: 100vh;
            width: 100%;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }

       .container-fluid {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

       .row {
            align-items: center;
            justify-content: center;
        }

       .col-md-6 {
            padding: 20px;
        }

       .bg-cover {
            border-radius: 10px 0 0 10px;
        }

       .form-container {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 0 10px 10px 0;
        }

       .form-label {
            font-weight: bold;
            margin-bottom: 10px;
        }

       .form-control {
            height: 40px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

       .btn-primary {
            background-color: #337ab7;
            border-color: #337ab7;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 10px;
        }

       .btn-primary:hover {
            background-color: #23527c;
            border-color: #23527c;
        }

        @media (min-width: 768px) {
           .bg-cover {
                height: 100vh;
                width: 50%;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 bg-cover" style="background-image: url('vendor/adminlte/dist/img/logo006.jpg');">
                <!-- Contenido izquierdo -->
            </div>

            <div class="col-md-6 form-container">
                <h2 class="text-center mb-4">Restablecer Contraseña</h2>

                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña que te permitirá elegir una nueva.') }}
                </div>

                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Enviar Enlace de Restablecimiento de Contraseña por Correo Electrónico') }}
                    </button>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>