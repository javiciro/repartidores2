@extends('adminlte::page')

@section('title', 'Tesoreria')

@section('content')


<link rel="stylesheet"  href="{{ asset('css/tesoreria.css') }}">

<form action="{{ url('/tesoreria') }}" method="get" class="filter-form">
    @csrf
    <div class="container-fluid mt-0">
        <h1 style="color: #1285AD;">Tesorería</h1>

        <form action="{{ url('/tesoreria') }}" method="get" class="mb-4 filter-form">
            @csrf
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="start_date" class="filter-label">Fecha:</label>
                    <input type="date" name="start_date" class="form-control input" value="{{ request('start_date') }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="user_id" class="filter-label">Conductor:</label>
                    <select name="user_id" class="form-control input">
                        <option value="" {{ !request('user_id') ? 'selected' : '' }}>Todos</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="estado" class="filter-label">Estado:</label>
                    <select class="form-control input" name="estado">
                        <option value=""{{ empty(request('estado')) ? ' selected' : '' }}>Todos</option>
                        <option value="pendiente"{{ request('estado') == 'pendiente' ? ' selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="entregado"{{ request('estado') == 'entregado' ? ' selected' : '' }}>
                            Entregado
                        </option>
                    </select>
                </div>

                <div class="col-md-3 mb-2" style="display: flex; align-items: center; margin-top: 0.1cm;">
                    <label class="text-white">-</label>
                    <div class="borrar_limpiar">
                        <button type="submit" class="btn button button-danger">Buscar</button>
                        <button type="button" class="btn button button-danger"
                            onclick="window.location.href='{{ url('/tesoreria') }}'">Limpiar</button>
                    </div>
                </div>
            </div>
            <div class="walletBalanceCard">
                <div class="loader">
                    <div class="loader__bar"></div>
                    <div class="loader__bar"></div>
                    <div class="loader__bar"></div>
                    <div class="loader__bar"></div>
                    <div class="loader__bar"></div>
                    <div class="loader__ball"></div>
                  </div>

                <div class="svgwrapper">
                    <svg viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.539915" y="6.28937" width="21" height="4" rx="1.5" transform="rotate(-4.77865 0.539915 6.28937)"
                            fill="#7D6B9D" stroke="black"></rect>
                        <circle cx="11.5" cy="5.5" r="4.5" fill="#E7E037" stroke="#F9FD50" stroke-width="2"></circle>
                        <path
                            d="M2.12011 6.64507C7.75028 6.98651 12.7643 6.94947 21.935 6.58499C22.789 6.55105 23.5 7.23329 23.5 8.08585V24C23.5 24.8284 22.8284 25.5 22 25.5H2C1.17157 25.5 0.5 24.8284 0.5 24V8.15475C0.5 7.2846 1.24157 6.59179 2.12011 6.64507Z"
                            fill="#BF8AEB" stroke="black"></path>
                        <path
                            d="M16 13.5H23.5V18.5H16C14.6193 18.5 13.5 17.3807 13.5 16C13.5 14.6193 14.6193 13.5 16 13.5Z"
                            fill="#BF8AEB" stroke="black"></path>
                    </svg>
                </div>

                <div class="balancewrapper">
                    <span class="balanceHeading">Total valor hecho</span>
                    <p class="balance"><span id="currency">₹</span>${{ number_format($sumaValores, 2, '.', ',') }}</p>
                </div>
            </div>

            @if(count($datos) === 0)
                <div class="alert alert-info">
                    No se encontraron registros.
                </div>
            @endif

            <div class="table-container">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>observacion</th>
                            <th>cc</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Número de Factura</th>
                            <th>Correo del Cliente</th>
                            <th>Conductor</th>
                            <th>Fecha Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datos as $dato)
                            <tr class="{{ $dato->estado == 'pendiente' ? 'estado-pendiente' : '' }}">
                                <td>
                                    <form action="{{ url('/tesoreria/editar-estado/'.$dato->id) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <select name="estado" class="form-control"
                                            onchange="confirmChangeState(this)"
                                            {{ $dato->estado == 'entregado' ? 'disabled' : '' }}>
                                            <option value="pendiente" {{ $dato->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="entregado" {{ $dato->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $dato->observacion ?: 'Ninguna' }}</td>
                                <td>{{ $dato->cc }}</td>
                                <td>{{ $dato->cliente_nombre }}</td>
                                <td>${{ number_format($dato->valor, 2, '.', ',') }}</td>
                                <td>{{ $dato->numero_factura }}</td>
                                <td>{{ $dato->correo_cliente }}</td>
                                <td>{{ $dato->user->name }}</td>
                                <td>{{ $dato->created_at->timezone('America/Bogota')->format('d-m-Y g:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $datos->links() }}

            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </form>
</form>
@endsection

@section('js')
<script>
    function confirmChangeState(selectElement) {
        if (selectElement.value === 'entregado' && !confirm('¿Cambiar estado?')) {
            selectElement.value = 'pendiente'; // Revert the selection if the user cancels
        }

        selectElement.form.submit();
    }
    function submitSearchForm() {
    var formData = new FormData(document.getElementById('searchForm'));

    // Realizar una solicitud AJAX para buscar/filtrar
    $.ajax({
        url: '{{ url("/tesoreria") }}',
        method: 'GET',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Actualizar la parte de la página que contiene los resultados de la búsqueda
            $('#content-container').html(response);

            // Guardar el estado del sidebar en una cookie o en el almacenamiento local
            var sidebarState = $('#sidebar').hasClass('collapsed') ? 'collapsed' : 'expanded';
            localStorage.setItem('sidebarState', sidebarState);
        },
        error: function(error) {
            console.error('Error en la solicitud AJAX', error);
        }
    });
}

// Restaurar el estado del sidebar al cargar la página
$(document).ready(function() {
    var sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState === 'collapsed') {
        $('#sidebar').addClass('collapsed');
    }
});
</script>
@endsection

