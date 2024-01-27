@extends('adminlte::page')

@section('content')
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f2f2f2;
    }

    .main-container {
        margin: 20px;
    }

    .main-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .main-card-header {
        background-color:rgb(255, 208, 0)
        color: #ffffff;
        padding: 15px;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .main-title {
        font-size: 28px;
        text-transform: uppercase;
        margin: 0;
    }

    .btn-crear {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 15px 20px;
  gap: 8px;
  height: 60px;
  width: 200px;
  border: none;
  background: #FABC0B; /* Yellow background */
  color: #ffffff; /* White text color */
  border-radius: 50px;
  cursor: pointer;
  position: relative;
  transition: background 0.3s ease, color 0.3s ease; /* Smooth transition for background and text color */
}

.btn-crear .span {
  border-radius: 50%;
  background-color: #ffffff; /* White for the icon */
  padding: 10px;
  position: absolute;
  left: 0;
}

.lable {
  line-height: 22px;
  font-size: 17px;
  color: #ffffff; /* White text color */
  margin-left: 20px;
  font-family: sans-serif;
  letter-spacing: 1px;
}

.btn-crear:hover {
  background: #1285AD; /* Blue background on hover */
  color: #ffffff; /* White text color on hover */
}

.btn-crear:hover .svg-icon {
  animation: slope 0.8s linear infinite;
}

@keyframes slope {
  0% {}
  50% {
    transform: rotate(15deg);
  }
  100% {}
}


    .filter-form {
        margin-top: 20px;
        background-color: #ffffff;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .filter-field {
        margin-bottom: 15px;
    }

    .filter-label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .filter-input {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .table-container {
    margin-top: 20px;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    overflow: auto; /* Cambiado a 'auto' para permitir desplazamiento horizontal en pantallas pequeñas */
}

.table-header {
    background-color:#1197D4;
    color: #ffffff;
    font-weight: bold;
}

.table-row {
    transition: background-color 0.3s ease;
}

.table-row:hover {
    background-color: #f5f5f5;
}

@media (max-width: 600px) {
    /* Aplicar estilos específicos para pantallas pequeñas aquí */
    .table-container {
        overflow-x: auto; /* Agregado para permitir el desplazamiento horizontal en pantallas pequeñas */
    }

    /* Puedes ocultar ciertas columnas, cambiar el tamaño de fuente, etc. para mejorar la legibilidad en pantallas pequeñas */
}


    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .btn-crear-cliente {
            font-size: 14px;
            padding: 8px 16px;
        }
    }
    .borrar_limpiar {
    display: flex;
    align-items: center;
}

.borrar_limpiar .btn {
    margin-right: 10px;
    background-color: #e5e1e1;
}

.borrar_limpiar .btn:link,
.borrar_limpiar .btn:visited {
    text-transform: uppercase;
    text-decoration: none;
    color: #1285AD; /* Azul claro 2 para el color del texto */
    padding: 10px 25px;
    background-color: rgba(169, 169, 169, 0.5); /* Gris opaco */
    border: 2px solid rgba(19, 96, 131, 0.7); /* Azul opaco para el borde */
    border-radius: 12px;
    display: inline-block;
    transition: all .2s;
    position: relative;
}

.borrar_limpiar .btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(2, 47, 150, 0.5);
}

.borrar_limpiar .btn:active {
    transform: translateY(-3px);
}

.borrar_limpiar .btn::after {
    content: "";
    display: inline-block;
    height: 100%;
    width: 100%;
    border-radius: 12px;
    top: 0;
    left: 0;
    position: absolute;
    z-index: -1;
    transition: all .3s;
}

.borrar_limpiar .btn:hover::after {
    background-color: rgba(19, 96, 131, 0.7); /* Azul opaco */
    transform: scaleX(1.4) scaleY(1.5);
    opacity: 0;
}


.input {
  max-width: 190px;
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
.notification {
    position: relative;
    background-color: ;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.notiglow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.4) 10%, rgba(255, 255, 255, 0.4) 90%, rgba(255, 255, 255, 0) 100%);
    border-radius: 8px;
    pointer-events: none;
}

.notiborderglow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 8px;
    pointer-events: none;
}

.notititle {
    font-size: 1.5em;
    color: #333;
    font-weight: bold;
}

.notibody {
    margin-top: 10px;
    color: #555;
}

/* Estilos responsivos */
@media (max-width: 600px) {
    .notification {
        padding: 15px;
    }

    .notititle {
        font-size: 1.2em;
    }

    .notibody {
        margin-top: 8px;
        font-size: 0.9em;
    }
}
.walletBalanceCard {
  width: 300px;
  height: 120px;
  background-color: #eaebf5;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: 12px;
  padding: 0px 12px;
  font-family: Arial, Helvetica, sans-serif;
}
.svgwrapper {
  width: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.svgwrapper svg {
  width: 100%;
}
.balancewrapper {
  display: flex;
  align-items: flex-start;
  justify-content: flex-start;
  flex-direction: column;
  width: 120px;
  gap: 0px;
}
.balanceHeading {
  font-size: 8px;
  color: rgb(214, 214, 214);
  font-weight: 100;
  letter-spacing: 0.6px;
}
.balance {
  font-size: 13.5px;
  color: white;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.addmoney {
  padding: 1px 15px;
  border-radius: 20px;
  background-color: #c083eb;
  color: white;
  border: none;
  font-size: 12px;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
}
.addmoney:hover {
  background-color: whitesmoke;
  color: #9c59cc;
}
.plussign {
  font-size: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}



</style>


<div class="main-container">
    <div class="main-card">
        <div class="main-card-header">
            <div class="notification">
                <div class="notiglow"></div>
                <div class="notiborderglow"></div>
                <div class="notititle">Clientes Creados Universal</div>
                <div class="notibody">Registra y visualiza fácilmente tus pedidos aquí. Simplifica el proceso de registro.</div>
            </div>
            
            <a href="{{ route('conductores.create') }}" class="btn-crear">
                <span class="span">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 23 21" height="21" width="23" class="svg-icon">
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="black" d="M1.97742 19.7776C4.45061 17.1544 7.80838 15.5423 11.5068 15.5423C15.2053 15.5423 18.5631 17.1544 21.0362 19.7776M16.2715 6.54229C16.2715 9.17377 14.1383 11.307 11.5068 11.307C8.87535 11.307 6.74212 9.17377 6.74212 6.54229C6.74212 3.91082 8.87535 1.77759 11.5068 1.77759C14.1383 1.77759 16.2715 3.91082 16.2715 6.54229Z"></path>
                    </svg>
                </span>
                <span class="lable">Crear cliente</span>
            </a>

              
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
                      <button  href="{{ route('conductores.index') }}" class="btn button button-danger">Limpiar</button>
                    </div>
                </div>
                
                
            </div>
        </form>

        <!-- Contenido Principal -->
        <div class="walletBalanceCard">
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
              <span class="balanceHeading">Wallet balance</span>
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
                            <th>Fecha de Creación</th>
                            <th>Número de Placa</th>
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
                                <td>{{ $cliente->created_at->timezone('America/Bogota')->format('d-m-Y g:i A') }}</td>
                                <td>{{ $cliente->num_placa }}</td>
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
@endsection
