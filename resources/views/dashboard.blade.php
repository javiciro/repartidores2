@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')


<link rel="stylesheet"  href="{{ asset('css/dashboard.css') }}">
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