@extends('master.master')
@section('contenido_principal')

@if(session('usuario')['TIPO']=='Jefe Tecnico')
<a href="#" class="float" title="CREAR ODT">
    <i class="fa-solid fa-plus my-float" title="CREAR ODT" style="color: #ffffff;"></i>
    </a>
@endif
<div class='container-fluid'>
    <div class="row mt-4 me-5 mb-0">
        <div class="col-auto me-auto"></div>
        @if(session('usuario')['TIPO']=='Jefe Tecnico')
        <div class="col-auto mb-0">
            <b>Desea crear una nueva ODT? </b>
            <button type="button" class="btn btn-warning text-white" title="CREAR ODT"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Crear ODT</button>
        </div>
        @endif
      </div>
    
    <div class='col me-5 ms-5 table-responsive'>
        <table class="table text-center" style="width:100%">
            <thead>
              <tr class=>
                <th scope="col">ID</th>
                <th scope="col">Numero ODT</th>
                <th scope="col">Tipo de trabajos</th>
                <th scope="col">Fecha de asignación</th>
                <th scope="col">Técnico asignado</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha de inicio</th>
                <th scope="col">Fecha de termino</th>
                <th scope="col">Acciones</th>

              </tr>
            </thead>
            <tbody>
                
                @if(count($odts) > 0)
                
                @foreach($odts as $odt)
                <tr>
                <th scope="row">#{{$odt->ID_odt}}</th>
                <td>{{$odt->Numero_odt}}</td>
                <td>
                  @if($odt->Tipo_trabajo == "MC") Mantención Correctiva
                  @elseif($odt->Tipo_trabajo == "MPD") Mantención Predictiva
                  @elseif($odt->Tipo_trabajo == "MPV") Mantención Preventiva
                  @elseif($odt->Tipo_trabajo == "I") Instalación
                  @elseif($odt->Tipo_trabajo == "D") Desinstalación
                  @endif
                </td> 
                
                <td>{{ \Carbon\Carbon::parse($odt->Fecha_inicio)->format('d-m-Y') }}</td>   
                <td>@foreach($odt->usuarioAsig as $asignacion)
                  {{$asignacion->NOMBRE}}@endforeach
                </td>          
                <td>@if($odt->Estado == "A") Asignada
                  @elseif($odt->Estado == "EC") En Camino
                  @elseif($odt->Estado == "EP") En Proceso
                  @elseif($odt->Estado == "P") Pospuesto
                  @elseif($odt->Estado == "F") Finalizada
                @endif</td>
                <td>
                        {{ \Carbon\Carbon::parse($odt->Fecha_inicio)->format('d-m-Y') }}
                    
                </td>
                <td>
                    @if($odt->Estado != 'F')
                        -
                    @elseif($odt->Estado == 'F')
                        {{ \Carbon\Carbon::parse($odt->Fecha_cierre)->format('d-m-Y') }}
                    @endif
                </td>
                <td>
                  @if($odt->ID_reporte != NULL)
                  <a class="btn btn-warning text-white" title="Revisar Reporte de ODT" href="{{route('Detalle Reporte', $odt->ID_reporte)}}"><i class="fa-solid fa-info"></i></a> 
                  @endif
                  @if($odt->Estado == 'A')
                    <a class="btn btn-primary text-white" title="Cambiar estado EN CAMINO" href="{{route('en.camino', $odt->ID_odt)}}">
                      <i class="fa-solid fa-truck-fast"></i>
                    </a>
                  @elseif($odt->Estado == 'EC')
                    <a class="btn btn-info text-white" title="Cambiar estado EN PROCESO" href="{{route('cambiar.proceso', $odt->ID_odt)}}">
                      <i class="fa-regular fa-circle-play"></i>
                    </a>
                  @elseif($odt->Estado == 'EP')
                    <a class="btn btn-success text-white" title="Cambiar estado FINALIZADO" href="{{route("Cerrar ODT", $odt->ID_odt)}}">
                        <i class="fa-solid fa-check"></i>
                    </a>
                  @endif

                  @if($odt->Estado == 'F')
                    <a href="{{route('pdf_odt', $odt->ID_odt)}}" class="btn btn-danger text-white" title="Generar PDF"><i class="fa-solid fa-file-pdf"></i></i></a>
                  @endif
                  
                </td>
                @endforeach
    {{-- Aquí puedes iterar sobre la lista y mostrar los datos si es necesario --}}
                @else
                    <td>La lista está vacía.</td>
                @endif
              </tr>
            </tbody>
          </table>
    </div>
    @if($errors->any())

       @if($errors->first() <> '1' && $errors->first() <> '2'  && $errors->first() <> '3')                 
        <script>
            Swal.fire({
                //customClass: {
                //    confirmButton: 'swalBtnColor'
                //},
                title: 'Error!',
                text: '{!!$errors->first()!!}',
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#fcab00',
            })
        </script> 
        @elseif($errors->first() == '1')
        <script>
            Swal.fire({
                //customClass: {
                //    confirmButton: 'swalBtnColor'
                //},
                title: 'Se creó!',
                text: 'Orden de Trabajo asignada correctamente!',
                icon: 'success',
                confirmButtonText: 'OK!',
                confirmButtonColor: '#fcab00',
            })
        </script>
        @elseif($errors->first() == '2')
        <script>
            Swal.fire({
                //customClass: {
                //    confirmButton: 'swalBtnColor'
                //},
                title: 'Se actualizó!',
                text: 'Orden de Trabajo actualizada correctamente!',
                icon: 'success',
                confirmButtonText: 'OK!',
                confirmButtonColor: '#fcab00',
            })
        </script>
         @elseif($errors->first() == '3')
         <script>
             Swal.fire({
                 //customClass: {
                 //    confirmButton: 'swalBtnColor'
                 //},
                 title: 'Se Finalizó!',
                 text: 'Orden de Trabajo cerrada correctamente!',
                 icon: 'success',
                 confirmButtonText: 'OK!',
                 confirmButtonColor: '#fcab00',
             })
         </script>
        @endif
                        
    @endif

</div>



@endsection