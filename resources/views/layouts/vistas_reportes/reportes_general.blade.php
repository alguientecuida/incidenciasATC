@extends('master.master')

@section('contenido_principal')

<div class='container-fluid'>
    <div class="row mt-2 me-5">
        
          
          
        </div>      
        
    <div class='col'></div>
    <div class='col m-5'>
        <table id="reportes" class="table text-center" style="width:100%">
            <thead>
              <tr>
                <th scope="col" data-ordenar="ID">ID</th>
                <th scope="col">Fecha de reporte</th>
                <th scope="col">Sucursal</th>
                <th scope="col">Tipo de reporte</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha Actualización</th>
                <th scope="col">Acciones</th>

              </tr>
            </thead>
            <tbody>
            @if(count($reportes) > 0)

                @foreach ($reportes as $reporte)
                
                @php

                    $ultimaAct = App\Models\REVISION::select('*')->where('ID_Reporte', $reporte->ID_Reporte)->orderBy('Fecha', 'desc')->first();
                @endphp
                @if($ultimaAct->Estado != 'F')
              <tr class='text-center  @if($ultimaAct->Estado == 'DS')
                    table-secondary
                    @elseif($ultimaAct->Estado == 'DJT')
                    table-info
                    @elseif($ultimaAct->Estado == 'DT')
                    table-warning
                    @elseif($ultimaAct->Estado == 'DC')
                    table-danger
                    @elseif($ultimaAct->Estado == 'TE')
                    table-dark
                    @elseif($ultimaAct->Estado == 'DAC')
                    table-primary
                    @elseif($ultimaAct->Estado == 'F')
                    table-success
                @endif'>
                
                    <th scope="row">{{$reporte->ID_Reporte}}</th>
                    <td>{{ \Carbon\Carbon::parse($reporte->Fecha)->format('d-m-Y') }}</td>
                    <td>{{ $reporte->sucursal->NOMBRE_SUCURSAL}}</td>
                    <td>@foreach ($reporte->tipos_fallas as $indice => $falla)
                        {{ $falla->tipo }}
                        @if ($indice !== count($reporte->tipos_fallas) - 1)
                          -
                        @endif
                      @endforeach
                    @if($ultimaAct->Estado == 'DS')
                        <td>Derivado a Soporte</td>
                    @elseif($ultimaAct->Estado == 'DJT')
                        <td>Derivado a Jefe de Técnicos</td>
                    @elseif($ultimaAct->Estado == 'DT')
                        <td>Visita Técnica agendada</td>
                    @elseif($ultimaAct->Estado == 'DC')
                        <td>Derivado a cliente</td>
                    @elseif($ultimaAct->Estado == 'TE')
                        <td>Derivado a Técnico Externo</td>
                    @elseif($ultimaAct->Estado == 'DAC')
                        <td>Derivado a Area Comerical</td>
                    @elseif($ultimaAct->Estado == 'F')
                        <td>Finalizado</td>
                    @endif
                    
                    <td>{{ \Carbon\Carbon::parse($ultimaAct->Fecha)->format('d-m-Y') }}</td>
                    <td><a class="btn btn-warning material-symbols-outlined text-white" title="Seguimiento" href="{{route('Detalle Reporte', $reporte->ID_Reporte)}}">
                        info</a> 
                @endif
                @endforeach
            
                
    {{-- Aquí puedes iterar sobre la lista y mostrar los datos si es necesario --}}
                @else
                    <td>La lista está vacía.</td>
                @endif
              </tr>
            </tbody>
          </table>
          <div class="row justify-content-between">
            <div class="col-4">
                <span id="mostrandoInfo"></span>
            </div>

            <div id="paginacion" class="col-4">
                <label for="elementosPorPagina">Elementos por página:</label>
                <select id="elementosPorPagina">
                    <option value="5">20</option>
                    <option value="10">50</option>
                    <option value="20">100</option>
                </select>
                <button id="anterior">Anterior</button>
                <button id="siguiente">Siguiente</button>
                
            </div>
          </div>
    </div>         
</div>

@if(session('usuario')['TIPO'] == 'Soporte')

@endif
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
                text: 'El reporte se creó correctamente!',
                icon: 'success',
                confirmButtonText: 'OK!',
                confirmButtonColor: '#fcab00',
            })
        </script>
        @endif
                        
    @endif

    
    

</div>
@section('js')
    <script>
        $('.js-example-basic-single').select2({
        });
    </script>
@stop


@endsection