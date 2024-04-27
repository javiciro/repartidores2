@extends('adminlte::page')

@section('title', 'Conductores')

@section('content')
<link rel="stylesheet"  href="{{ asset('css/conductores.css') }}">
<div class="main-container">
  <div class="main-card">
    <div class="main-card-header">
      <div class="notification">
        <div class="notiglow"></div>
        <div class="notiborderglow"></div>
        <div class="notititle">Clientes Creados Universal</div>
        <div class="notibody">Registra y visualiza fácilmente tus pedidos aquí. Simplifica el proceso de registro.</div>
      </div>  
    </div>
        <!-- Formulario de Filtros -->
        <form method="GET" action="{{ route('conductores.index') }}" class="filter-form">
            <div class="row">
                <div class="col-md-3 filter-field">
                    <label for="fecha_creacion" class="filter-label">Fecha Creación:</label>
                    <input type="date" class="form-control input" name="fecha_creacion" value="{{ request('fecha_creacion') }}">
                </div>
                <div class="col-md-3 filter-field">
                    <label for="estado" class="filter-label">Estado:</label>
                    <select class="form-control input" name="estado">
                        <option value=""{{ empty(request('estado')) ? ' selected' : '' }}>Todos</option>
                        <option value="pendiente"{{ request('estado') == 'pendiente' ? ' selected' : '' }}>Pendiente</option>
                        <option value="entregado"{{ request('estado') == 'entregado' ? ' selected' : '' }}>Entregado</option>
                    </select>
                </div>
                <div class="col-md-3 filter-field">
                    <label for="cliente_filtro" class="filter-label">Filtrar Cliente:</label>
                    <input type="text" class="form-control input" name="cliente_filtro" value="{{ request('cliente_filtro') }}">
                </div>

                <div class="col-md-3 mb-2" style="display: flex; align-items: center; margin-top: 0.1cm;">
                    <label class="text-white">-</label>
                    <div class="borrar_limpiar">
                      <button type="submit" class="btn button button-danger">Buscar</button>
                      <button type="button" class="btn button button-danger" onclick="limpiarFiltros()">Limpiar</button>


                    </div>
                </div>
                
                
            </div>
        </form>


        
        <div class="walletBalanceCard">
          <a href="{{ route('conductores.create') }}" class="btn-crear">
            <span class="span">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 23 21" height="21" width="23" class="svg-icon">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="black" d="M1.97742 19.7776C4.45061 17.1544 7.80838 15.5423 11.5068 15.5423C15.2053 15.5423 18.5631 17.1544 21.0362 19.7776M16.2715 6.54229C16.2715 9.17377 14.1383 11.307 11.5068 11.307C8.87535 11.307 6.74212 9.17377 6.74212 6.54229C6.74212 3.91082 8.87535 1.77759 11.5068 1.77759C14.1383 1.77759 16.2715 3.91082 16.2715 6.54229Z"></path>
                </svg>
            </span>
            <span class="lable">Crear cliente</span>
        </a>
            <div class="svgwrapper">
              <svg viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect
                  x="0.539915"
                  y="6.28937"
                  width="21"
                  height="4"
                  rx="1.5"
                  transform="rotate(-4.77865 0.539915 6.28937)"
                  fill="#7D6B9D"
                  stroke="black"
                ></rect>
                <circle
                  cx="11.5"
                  cy="5.5"
                  r="4.5"
                  fill="#E7E037"
                  stroke="#F9FD50"
                  stroke-width="2"
                ></circle>
                <path
                  d="M2.12011 6.64507C7.75028 6.98651 12.7643 6.94947 21.935 6.58499C22.789 6.55105 23.5 7.23329 23.5 8.08585V24C23.5 24.8284 22.8284 25.5 22 25.5H2C1.17157 25.5 0.5 24.8284 0.5 24V8.15475C0.5 7.2846 1.24157 6.59179 2.12011 6.64507Z"
                  fill="#BF8AEB"
                  stroke="black"
                ></path>
                <path
                  d="M16 13.5H23.5V18.5H16C14.6193 18.5 13.5 17.3807 13.5 16C13.5 14.6193 14.6193 13.5 16 13.5Z"
                  fill="#BF8AEB"
                  stroke="black"
                ></path>
              </svg>
            </div>
          
            <div class="balancewrapper">
              <span class="balanceHeading">Total valor hecho</span>
              <p class="balance"><span id="currency">₹</span>${{ number_format($totalValor, 2, '.', ',') }}</p>
            </div>
          
            
          </div>
          
          
            <div class="table-container">
                @if($clientes->isEmpty())
                    <p class="empty-row">No hay clientes creados.</p>
                @else
                    <table class="table table-bordered table-striped table-white table-hover">
                        <thead class="table-header">
                        <tr>
                            <!-- Ajusta los nombres de las columnas según tus modelos -->
                            <th>Estado</th>
                            <th>Nombre del Cliente</th>
                            <th>CC cliente</th>
                            <th>Número de Factura</th>
                            <th>Observación</th>
                            <th>Valor</th>
                            <th>Orden Provisional</th>
                            <th>Correo del Cliente</th>
                            <th>Dirección del Cliente</th>
                            <th>Teléfono del Cliente</th>
                            <th>Número de Placa</th>
                            <th>Fecha de Creación</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clientes as $cliente)
                            <tr class="table-row">
                                <!-- Ajusta los nombres de las columnas según tus modelos -->
                                <td>{{ $cliente->estado }}</td>
                                <td class="font-size-large">{{ $cliente->cliente_nombre }}</td>
                                <td>{{ $cliente->cc }}</td>
                                <td>{{ $cliente->numero_factura }}</td>
                                <td>{{ $cliente->observacion ?: 'Ninguna' }}</td>
                                <td>{{ number_format($cliente->valor, 2, '.', ',') }}</td>
                                <td>{{ $cliente->num_factura }}</td>
                                <td>{{ $cliente->correo_cliente }}</td>
                                <td>{{ $cliente->direccion_cliente }}</td>
                                <td>{{ $cliente->telefono_cliente }}</td>
                                <td>{{ $cliente->num_placa }}</td>
                                <td>{{ $cliente->created_at->timezone('America/Bogota')->format('d-m-Y g:i A') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $clientes->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
<script>
  function limpiarFiltros() {
    document.querySelectorAll('.filter-form input, .filter-form select').forEach(function(el) {
      el.value = '';
    });
    document.querySelector('.filter-form').submit();
  }
</script>

@endsection