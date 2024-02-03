@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')


<style>
.contenedor {
    margin-top: 70px;
  display: grid;
  grid-template-columns: repeat(12, minmax(0, 1fr));
  gap: 10px;
  row-gap: 40px;
}

.ciro {
    grid-column: 4 / span 3;
  text-align: center;
  /* width: 300px;
  height: 400px; */
  background-color: #F7F7F7;
  border-radius: 10px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  position: relative;
  transition: all 0.3s ease;
}

.ciro:before {
  content: "";
  position: absolute;
  top: -100%;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom right, #FF5F6D, #FF9671);
  transform: rotate(-45deg);
  transition: all 0.3s ease;
  z-index: -1;
}

.ciro:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
}

.ciro:hover:before {
  top: 0;
  left: 0;
}

.ciro-content {
  padding: 20px;
  text-align: center;
}

.ciro-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #333;
}

.ciro-description {
  font-size: 16px;
  color: #777;
  margin-bottom: 20px;
}

.ciro-button {
  padding: 10px 20px;
  background-color: #e7ef07;
  color: #FFF;
  border: none;
  border-radius: 4px;
  font-size: 18px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.ciro-button:hover {
  background-color: #FF3A4C;
}

.caja {
    grid-column: 7 / span 3;
  text-align: center;
  /* width: 300px;
  height: 400px; */
  background-color: #F7F7F7;
  border-radius: 10px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  position: relative;
  transition: all 0.3s ease;
}

.caja:before {
  content: "";
  position: absolute;
  top: -100%;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom right, #FF5F6D, #FF9671);
  transform: rotate(-45deg);
  transition: all 0.3s ease;
  z-index: -1;
}

.caja:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
}

.caja:hover:before {
  top: 0;
  left: 0;
}

.caja-content {
  padding: 20px;
  text-align: center;
}

.caja-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #333;
}

.caja-description {
  font-size: 16px;
  color: #777;
  margin-bottom: 20px;
}

.caja-button {
  padding: 10px 20px;
  background-color: #FF5F6D;
  color: #FFF;
  border: none;
  border-radius: 4px;
  font-size: 18px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.caja-button:hover {
  background-color: #089eee;
}




    
    </style>



<div class="contenedor">
    <div class="ciro">
        <div class="ciro-content">
          <div class="ciro-title">Conductores</div>
          <p class="ciro-description"> 
            Realiza registros y obtén informes relacionados con las entregas de los conductores de manera eficiente.</p>
          
        </div>
      </div>
    <div class="caja">
        <div class="caja-content">
          <div class="caja-title">Tesorería</div>
          <p class="caja-description">Accede a informes de las actividades de los repartidores con opciones de búsqueda y registra la entrega exitosa del repartidor.</p>
          
        </div>
      </div>
    <div class="ciro">
        <div class="ciro-content">
          <div class="ciro-title">Estadisticas</div>
          <p class="ciro-description">Se presenta un resumen breve de las acciones diarias, semanales, mensuales y anuales de los conductores para una gestión eficiente.</p>
        </div>
      </div>
    <div class="caja">
        <div class="caja-content">
          <div class="caja-title">Roles y Permisos</div>
          <p class="caja-description">Gestión de actividades de  los usuarios asignados que son  conductores, tesorería y administradores.</p>
        </div>
      </div>


</div>


@endsection

@section('css')
 <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
 <script> console.log('Hi!'); </script>
@stop