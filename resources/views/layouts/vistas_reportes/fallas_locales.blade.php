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
                <th scope="col">Tipo de reporte</th>
                <th scope="col">Problema</th>
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
              <tr class='text-center  table-danger'>
                
                    <th scope="row">{{$reporte->ID_Reporte}}</th>
                    <td>{{ \Carbon\Carbon::parse($reporte->Fecha)->format('d-m-Y') }}</td>
                   
                    <td>@foreach ($reporte->tipos_fallas as $indice => $falla)
                        {{ $falla->tipo }}
                        @if ($indice !== count($reporte->tipos_fallas) - 1)
                          -
                        @endif
                      @endforeach
                      <td>$ultimaAct->observacion<td>
                    @if($ultimaAct->Estado == 'DS')
                        <td>Derivado a Soporte</td>
                    @endif

                    
                    <td>{{ \Carbon\Carbon::parse($ultimaAct->Fecha)->format('d-m-Y') }}</td>
                    <td>
                        @if(session('usuario')['TIPO'] == 'Soporte') 
                            <a type="button" title="Solucionado" class="btn btn-success text-white" href="{{route('finalizar_reporte')}}">
                              <i class="fa-solid fa-check"></i>
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

            <nav>
              <ul class="pagination" id="paginacionTabla">
                  <!-- Los ítems de paginación se generarán dinámicamente aquí -->
              </ul>
            </nav>
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

<script>
  // Función para actualizar la paginación de la tabla
  function actualizarPaginacionTabla() {
      var itemsPorPagina = 20; // Número de filas por página
      var tabla = $("#reportes");
      var paginacionTabla = $("#paginacionTabla");

      var numFilas = tabla.find("tbody tr").length;
      var numPaginas = Math.ceil(numFilas / itemsPorPagina);

      // Oculta todas las filas y muestra solo las de la primera página
      tabla.find("tbody tr").hide();
      tabla.find("tbody tr").slice(0, itemsPorPagina).show();

      // Genera dinámicamente los ítems de paginación
      paginacionTabla.empty();
      for (var i = 1; i <= numPaginas; i++) {
          paginacionTabla.append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
      }

      // Lógica de cambio de página
      paginacionTabla.find("li").on("click", function () {
          var paginaActual = parseInt($(this).text());

          // Oculta todas las filas y muestra solo las de la página seleccionada
          tabla.find("tbody tr").hide();
          tabla.find("tbody tr").slice((paginaActual - 1) * itemsPorPagina, paginaActual * itemsPorPagina).show();

          // Marca como activa la página seleccionada
          $(this).addClass("active").siblings().removeClass("active");
      });
  }

  // Llamada inicial
  $(document).ready(function () {
      // Después de cargar los datos, actualiza la paginación de la tabla
      actualizarPaginacionTabla();
  });
</script>

@endsection
