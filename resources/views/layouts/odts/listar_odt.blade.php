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
    
    <div class='col me-5 ms-5'>
        <table class="table text-center" style="width:100%">
            <thead>
              <tr class=>
                <th scope="col">ID</th>
                <th scope="col">Numero ODT</th>
                <th scope="col">Tipo de trabajos</th>
                <th scope="col">Fecha de asignación</th>
                <th scope="col">Técnico asignado</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>

              </tr>
            </thead>
            <tbody>
                @if(count($odts) > 0)
                @foreach($odts as $odt)
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
                  @elseif($odt->Estado == "EP") En Proceso
                  @elseif($odt->Estado == "P") Pospuesto
                  @elseif($odt->Estado == "F") Finalizada
                @endif</td>
                <td>
                  @if($odt->ID_reporte != NULL)
                  <a class="btn btn-warning material-symbols-outlined text-white" title="Revisar Reporte de ODT" href="{{route('Detalle Reporte', $odt->ID_reporte)}}">info</a> 
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

       @if($errors->first() <> '1')                 
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
        @else
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
        @endif
                        
    @endif

</div>



@endsection