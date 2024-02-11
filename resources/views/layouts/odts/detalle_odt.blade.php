@extends('master.master')


@section('contenido_principal')

<div class="container-fluid text-center">
    <div class='col'></div>
    <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row color-header-detalle mt-3 m-3 justify-content-center rounded">
            <div class="col-md-8">
                 
               
                <div class="row ">
                    <div class="col">
                        <h2>ID: #<b>{{$odt->ID_odt}}</b></h2>
                        <div class="row">
                            <div class="col">
                              <h5>
                                TIPO TRABAJO:
                                @if($odt->Tipo_trabajo == "MC") 
                                <b>Mantención Correctiva</b>
                                @elseif($odt->Tipo_trabajo == "MPD") 
                                <b>Mantención Predictiva</b>
                                @elseif($odt->Tipo_trabajo == "MPV") 
                                <b>Mantención Preventiva</b>
                                @elseif($odt->Tipo_trabajo == "I") 
                                <b>Instalación</b>
                                @elseif($odt->Tipo_trabajo == "D") 
                                <b>Desinstalación</b>
                                @endif
                              </h5>
                              <h5>
                                FECHA DEL TRABAJO:
                                <b>{{ \Carbon\Carbon::parse($odt->Fecha_inicio)->format('d-m-Y') }}
                              </b></h5>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <H2>SUCURSAL:
                            <b>{{$odt->sucursal->NOMBRE_SUCURSAL}}</b></H2>
                        <div class="row">
                            <div class="col">
                              <h5>
                                Nombre Prioridad : <b>{{$empleado->NOMBRE}}</b>
                              </h5>
                              <h5>
                                Numero Prioridad : <b>{{$empleado->CELULAR}}</b>
                              </h5>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="row">
                    <div class="col pt-1">
                      <h5>
                        ESTADO:

                        @if($odt->Estado == "A") 
                        <a class="btn btn-secondary">Asignada</a>
                        @elseif($odt->Estado == "EC") 
                        <a class="btn btn-secondary">En Camino</a>
                        @elseif($odt->Estado == "EP") 
                        <a class="btn btn-secondary">En Proceso</a>
                        @elseif($odt->Estado == "P") 
                        <a class="btn btn-secondary">Pospuesto</a>
                        @elseif($odt->Estado == "F") 
                        <a class="btn btn-success">Finalizada</a>
                        @endif
                        <!--
                        @/if($ultimaAct->Estado == 'DS')
                        <a class="btn btn-secondary">Derivado a Soporte</a>
                        @/elseif($ultimaAct->Estado == 'DJT')
                        <a class="btn btn-info">Derivado a Jefe de Técnicos</a>
                        @/elseif($ultimaAct->Estado == 'DT')
                        <a class="btn btn-warning">Visita Técnica agendada</a>
                        @/elseif($ultimaAct->Estado == 'DC')
                        <a class="btn btn-danger">Derivado a cliente</a>
                        @/elseif($ultimaAct->Estado == 'TE')
                        <a class="btn btn-dark">Derivado a Técnico Externo</a>
                        @/elseif($ultimaAct->Estado == 'DAC')
                        <a class="btn btn-primary">Derivado a Area Comerical</a>
                        @/elseif($ultimaAct->Estado == 'F')
                        <a class="btn btn-success">Finalizado</a>
                        @/endif-->
                      </h5>
                      <h5>
                        Direccion: <b>{{$odt->sucursal->DIRECCION}}</b>
                      </h5>
                        <div class="row mt-1">
                            <div class="col">
                              
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
           
        </div>
      
        <div class="container-fluid text-center">
            <div class='col'></div>
            <!-- Stack the columns on mobile by making one full-width and the other half-width -->
                <div class="row color-header-detalle mt-3 m-3 justify-content-center rounded">
                    <div class="col-md-8">
                        @php
                        
                    
                        // Obtener las revisiones que coincidan con el ID del reporte y el estado de DJF
                        $revisiones = \App\Models\REVISION::where('ID_Reporte', $odt->ID_reporte)
                            ->where('ESTADO', 'DS')
                            ->get();
                    @endphp
                       
                        <div class="row ">
                            <div class="col">
                                <b>Tecnico asginado:@foreach($odt->usuarioAsig as $asignacion)
                                    {{$asignacion->NOMBRE}}@endforeach
                                </b>
                                <div class="row">
                                    <div class="col">
                                      <h5><b>
                                        DESCRIPCIÓN DEL TRABAJO:
                                            @if($odt->ID_reporte === NULL)
                                            <h4>{{ $odt->detalle_trabajo }}</h4>
                                            @else
                                            @foreach ($revisiones as $revision)
                                            <h4>{{ $revision->Observacion}}</h4>
                                                <!-- Otras propiedades de la revisión -->
                                            @endforeach
                                            @endif
                                      </b></h5>

                                      
                                        
                                    </div>  
                                      
                    </div>
                    @if($imagenes)
      <div class="pt-3">
      <p><b class="p-3 pdf">Imágenes</b></p>
              @foreach ($imagenes as $imagen)
                <img src="{{asset($imagen)}}" class="m-1">
              @endforeach
            </div>
            @endif
                   
                </div>

@endsection