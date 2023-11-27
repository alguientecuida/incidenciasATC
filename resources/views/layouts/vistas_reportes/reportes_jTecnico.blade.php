@extends('master.master')

@section('contenido_principal')

<div class='container-fluid'>
    <div class='col'></div>
    <div class='col m-5'>
        <table id="reportes" class="table table-striped text-center" style="width:100%">
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
              <tr class='text-center  table-info'>
                
                    <th scope="row">{{$reporte->ID_Reporte}}</th>
                    <td>{{ \Carbon\Carbon::parse($reporte->Fecha)->format('d-m-Y') }}</td>
                    <td>{{ $reporte->sucursal->NOMBRE_SUCURSAL}}</td>
                   
                    <td>@foreach ($reporte->tipos_fallas as $indice => $falla)
                        {{ $falla->tipo }}
                        @if ($indice !== count($reporte->tipos_fallas) - 1)
                          -
                        @endif
                      @endforeach
                    @if($ultimaAct->Estado == 'DJT')
                        <td>Derivado a Jefe Tecnicos</td>
                    @endif

                    
                    <td>{{ \Carbon\Carbon::parse($ultimaAct->Fecha)->format('d-m-Y') }}</td>
                    <td><a class="btn btn-warning material-symbols-outlined text-white" title="Seguimiento" href="{{route('Detalle Reporte', $reporte->ID_Reporte)}}">
                        info</a>
                        @if(session('usuario')['TIPO'] == 'Jefe Tecnico') 
                            <a type="button" title="Seguimiento" class="btn btn-success material-symbols-outlined text-white" href="{{route('Agregar Revisión', $reporte->ID_Reporte)}}">
                                rate_review
                            </a></td>
                        @endif
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
    @if($errors->any())
                        
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
                                
                        
                    @endif
    

</div>



@endsection