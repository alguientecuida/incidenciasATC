@extends('master.master')


@section('contenido_principal')
@php
    $ultimaAct = App\Models\REVISION::select('*')->where('ID_Reporte', $reporte->ID_Reporte)->orderBy('Fecha', 'desc')->first();
@endphp
<div class="container-fluid text-center">
    <div class='col'></div>
    <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row color-header-detalle mt-3 m-3 justify-content-center rounded">
            <div class="col-md-8">
                 
               
                <div class="row ">
                    <div class="col">
                        <h2>ID: #<b>{{$reporte->ID_Reporte}}</b></h2>
                        <div class="row">
                            <div class="col">
                              <h5>
                                TIPO REPORTE:
                                @foreach ($reporte->tipos_fallas as $indice => $falla)
                                  <b>{{ $falla->tipo }}</b>
                                  @if ($indice !== count($reporte->tipos_fallas) - 1)
                                    <b>-</b>
                                  @endif
                                @endforeach
                              </h5>
                              <h5>
                                FECHA REPORTE:
                                <b>{{ \Carbon\Carbon::parse($reporte->Fecha)->format('d-m-Y') }}
                              </b></h5>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <H2>SUCURSAL:
                            <b>{{$reporte->sucursal->NOMBRE_SUCURSAL}}</b></H2>
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
                        @if($ultimaAct->Estado == 'DS')
                        <a class="btn btn-secondary">Derivado a Soporte</a>
                        @elseif($ultimaAct->Estado == 'DJT')
                        <a class="btn btn-info">Derivado a Jefe de Técnicos</a>
                        @elseif($ultimaAct->Estado == 'DT')
                        <a class="btn btn-warning">Visita Técnica agendada</a>
                        @elseif($ultimaAct->Estado == 'DC')
                        <a class="btn btn-danger">Derivado a cliente</a>
                        @elseif($ultimaAct->Estado == 'TE')
                        <a class="btn btn-dark">Derivado a Técnico Externo</a>
                        @elseif($ultimaAct->Estado == 'DAC')
                        <a class="btn btn-primary">Derivado a Area Comerical</a>
                        @elseif($ultimaAct->Estado == 'F')
                        <a class="btn btn-success">Finalizado</a>
                        @endif
                      </h5>
                      <h5>
                        Direccion: <b>{{$reporte->sucursal->DIRECCION}}</b>
                      </h5>
                        <div class="row mt-1">
                            <div class="col">
                              <h5>
                                FECHA ACTUALIZACIÓN: <b>{{ \Carbon\Carbon::parse($ultimaAct->Fecha)->format('d-m-Y') }}</b>
                              </h5>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
           
        </div>
      

        <div class='row mt-3'>
            <div class="col-4 ms-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  @foreach ($detalles as $detalle)
                    <button class="nav-link1 text-reset mt-2" id="v-pills-{{$detalle->ID_Revisiones}}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{$detalle->ID_Revisiones}}" role="tab" aria-controls="v-pills-{{$detalle->ID_Revisiones}}" >
                      Fehca de revisión: {{ \Carbon\Carbon::parse($detalle->Fecha)->format('d-m-Y') }} <br>
                      ESTADO:
                      @if($detalle->Estado == 'DS')
                        Derivado a Soporte
                      @elseif($detalle->Estado == 'DJT')
                        Derivado a Jefe de Técnicos
                      @elseif($detalle->Estado == 'DT')
                        Visita Técnica agendada
                      @elseif($detalle->Estado == 'DC')
                        Derivado a cliente
                      @elseif($detalle->Estado == 'TE')
                        Derivado a Técnico Externo
                      @elseif($detalle->Estado == 'DAC')
                        Derivado a Area Comerical
                      @elseif($detalle->Estado == 'F')
                        <a>Finalizado</a>
                      @endif
          </button>
                  @endforeach
        
      </div>
            </div>
              <div class="col me-3 mt-2">
                <div class="tab-content" id="v-pills-tabContent">
                  @foreach ($detalles as $detalle)
                  <div class="tab-pane fade" id="v-pills-{{$detalle->ID_Revisiones}}" role="tabpanel" aria-labelledby="v-pills-{{$detalle->ID_Revisiones}}-tab" tabindex="0">
                    <div class="container bg-body-secondary rounded">
                      <div class="row justify-content-between pt-1">
                        <div class="col-4 mt-4">
                          <h4>
                            FECHA DE REVISION: <b>{{ \Carbon\Carbon::parse($detalle->Fecha)->format('d-m-Y') }}</b>
                          </h4>
                        </div>
                        <div class="col-4 mt-4">
                          <H4>
                            ESTADO:
                            @if($detalle->Estado == 'DS')
                              <a class="btn btn-secondary">Derivado a Soporte</a>
                            @elseif($detalle->Estado == 'DJT')
                              <a class="btn btn-info">Derivado a Jefe de Técnicos</a>
                            @elseif($detalle->Estado == 'DT')
                              <a class="btn btn-warning">Visita Técnica agendada</a>
                            @elseif($detalle->Estado == 'DC')
                              <a class="btn btn-danger">Derivado a cliente</a>
                            @elseif($detalle->Estado == 'TE')
                              <a class="btn btn-dark">Derivado a Técnico Externo</a>
                            @elseif($detalle->Estado == 'DAC')
                              <a class="btn btn-primary">Derivado a Area Comerical</a>
                            @elseif($detalle->Estado == 'F')
                              <a class="btn btn-success">Finalizado</a>
                            @endif 
                          </H4>
                        </div>
                      </div>
                      <hr class="border-warning">

                      <H4 class="p-2">
                        ENCARGADO DE LA REVISION: <b>{{$detalle->usuarios->NOMBRE}}</b>
                      </H4>
                      <hr class="border-warning">
                      <div class='p5'>
                        <h4>
                          Observacion:
                        </h4>
                      </div>
                      <div class='pt-2 pb-5'>
                        <h4>
                          {{$detalle->Observacion}}
                        </h4>
                      </div>
                      @if($detalle->Estado == 'DT')
                        <h5>Dirección de la visita técnica:</h5> <h4><b>{{$reporte->sucursal->DIRECCION}}</b></h4>
                      @endif
                    </div>  
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
        </div>
        
        </div>
      </div>


      </div>
    </div>
</div>


@endsection