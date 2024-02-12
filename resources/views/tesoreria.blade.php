@extends('adminlte::page')

@section('title', 'Tesoreria')

@section('content')

<link rel="stylesheet"  href="{{ asset('css/tesoreria.css') }}">

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
    </form>

    <div class="walletBalanceCard">
        <div class="loader">
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__ball"></div>
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
</div>

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
