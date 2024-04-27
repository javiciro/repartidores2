@extends('adminlte::page')

@section('content')
<style>
  .navbar {
width: 100%;
background-color: #1197D4;
display: flex;
justify-content: space-between;
align-items: center;
padding: 20px 50px;
}
</style>
<link rel="stylesheet"  href="{{ asset('css/crudClientes.css') }}">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card-body">
        <div class="main-container">
          <div class="main-card">
            <div class="main-card-header">
              <div class="notification">
                <div class="notititle"> Edita los Clientes Creados Universal</div>
                <div class="notibody">Permite Corregir Algun Error Cometido a la Hora de Regristar un Cliente.</div>
              </div>
            </div>
                                     <!-- Notificaciones -->
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
            <!-- Formulario de Filtros -->
            <form method="GET" action="{{ route('conductores.crud') }}" class="filter-form">
              <div class="row">
                <div class="col-md-2 filter-field">
                  <label for="start_date" class="filter-label">Por Fecha:</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2 filter-field">
                  <label for="user_id" class="filter-label">Usuario:</label>
                  <select class="form-control" id="user_id" name="user_id">
                    <option value="">Seleccionar usuario</option>
                    @foreach($users as $user)
                      <option value="{{ $user->id }}" {{ request('user_id') == $user->id? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2 filter-field">
                  <label for="estado" class="filter-label">Estado:</label>
                  <select class="form-control" id="estado" name="estado">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente'? 'selected' : '' }}>Pendiente</option>
                    <option value="entregado" {{ request('estado') == 'entregado'? 'selected' : '' }}>Entregado</option>
                  </select>
                </div>
                <div class="col-md-2 filter-field">
                  <label for="search" class="filter-label">Búsqueda:</label>
                  <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Buscar...">
                </div>
                <div class="col-md-3 mb-2" style="display: flex; align-items: center; margin-top: 0.1cm;">
                  <label class="text-white">-</label>
                  <div class="borrar_limpiar">
                    <button type="submit" class="btn button button-danger">Buscar</button>
                    <button type="button" class="btn button button-danger" onclick="window.location.href='{{ url('/conductores/crud') }}'">Limpiar</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- Fin del formulario de filtros -->
            <div class="table-container">
              @if($clientes->isEmpty())
                <p class="empty-row">No hay clientes creados.</p>
              @else
                <table class="table table-bordered table-striped table-white table-hover">
                  <thead class="table-header">
                    <tr>
                      <!-- Ajusta los nombres de las columnas según tus modelos -->
                      <th>Acciones</th>
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
                      <th>Fecha de Creación</th>
                      <th>Número de Placa</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($clientes as $cliente)
                      <tr class="table-row">
                        <td>
                          <!-- Edit button -->
                          <a href="{{ route('conductores.edit', ['id' => $cliente->id]) }}" class="btn btn-primary btn-sm m-1">
                            <i class="fas fa-edit"></i>
                            <span class="d-none d-sm-inline">Editar</span>
                          </a>

                          <!-- Delete button -->
                         <!-- Delete button -->
                            <form action="{{ route('conductores.destroy', ['id' => $cliente->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este cliente? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm m-1">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-sm-inline">Eliminar</span>
                                </button>
                            </form>
                            
   
                            

                        <!-- Ajusta los nombres de las columnas según tus modelos -->
                        <td>{{ $cliente->estado }}</td>
                        <td class="font-size-large">{{ $cliente->cliente_nombre }}</td>
                        <td>{{ $cliente->cc }}</td>
                        <td>{{ $cliente->numero_factura }}</td>
                        <td>{{ $cliente->observacion?: 'Ninguna' }}</td>
                        <td class="accent-color-1">{{ number_format(floatval(str_replace('.', '', $cliente->valor)), 0, ',', '.') }}</td>
                        <td>{{ $cliente->num_factura }}</td>
                        <td>{{ $cliente->correo_cliente }}</td>
                        <td>{{ $cliente->direccion_cliente }}</td>
                        <td>{{ $cliente->telefono_cliente }}</td>
                        <td>{{ $cliente->created_at->timezone('America/Bogota')->format('d-m-Y g:i A') }}</td>
                        <td class="accent-color-2">{{ $cliente->num_placa }}</td>
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
    </div>
  </div>
</div>
@endsection