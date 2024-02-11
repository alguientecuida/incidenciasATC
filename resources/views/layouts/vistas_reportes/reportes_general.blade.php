@extends('master.master')

@section('contenido_principal')

<div class='container-fluid'>
    <div class="row mt-2 me-5">
        <div class="row justify-content-between pt-3">
            <div class="col-4 ms-5">
                <form class="d-flex" name="buscador" action="{{ route('reportes.buscar') }}" method="GET">
                    <input id="query" name="buscarpor" class="form-control me-2" type="search" placeholder="Buscar por Nombre de Sucursal" aria-label="Search" value="{{$buscarpor ?? ''}}">
                  </form>
            </div>
            <div class="col-4">
                
            </div>
          </div>
        
        
          
        </div>      
        
    <div class='col'></div>
    <div class='col ms-5 me-5 mb5 mt-3'>
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

            <nav>
                <ul class="pagination" id="paginacionTabla">
                    <!-- Los ítems de paginación se generarán dinámicamente aquí -->
                </ul>
            </nav>
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
    <script>
        $(document).ready(function () {
            $('#query').on('input', function (event) {
                
                // Verifica si la tecla presionada es "Enter" y previene el envío del formulario
                if (event.key === 'Enter') {
                    event.preventDefault();
                } else {
                    // Si la tecla no es "Enter", realiza la búsqueda AJAX
                    $.ajax({
                        url: '{{ route('reportes.buscar') }}',
                        method: 'GET',
                        data: { buscarpor: $(this).val() },
                        success: function (data) {
                            actualizarTabla(data);
                        }
                    });
                }
            });

            function actualizarTabla(data) {
                var tbody = $('#reportes tbody');
                tbody.empty();

                if (data.length > 0) {
                    $.each(data, function (index, reporte) {
                        // Excluir reportes finalizados
                        if (reporte.ultimo_estado === 'F') {
                            return; // Salta a la siguiente iteración del bucle
                        }
                        var row = '<tr class="';

    // Asignar la clase según el estado del reporte
                        switch (reporte.ultimo_estado) {
                            case 'DS':
                                row += 'table-secondary';
                                break;
                            case 'DJT':
                                row += 'table-info';
                                break;
                            case 'DT':
                                row += 'table-warning';
                                break;
                            case 'DC':
                                row += 'table-danger';
                                break;
                            case 'TE':
                                row += 'table-dark';
                                break;
                            case 'DAC':
                                row += 'table-primary';
                                break;
                            case 'F':
                                row += 'table-success';
                                break;
                            default:
                                // Clase por defecto si el estado no coincide con ninguno de los anteriores
                                row += 'table-light';
                                break;
                        }
                        row += '">';
                        row += '<td>' + reporte.ID_Reporte + '</td>';
                        // Formatear la fecha (asumiendo que 'Fecha' es una cadena de fecha válida)
                        var fecha = new Date(reporte.Fecha);
                        var dia = fecha.getDate().toString().padStart(2, '0'); // Asegura dos dígitos, rellenando con cero si es necesario
                        var mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Sumar 1 ya que los meses en JavaScript van de 0 a 11
                        var anio = fecha.getFullYear();

                        row += '<td>' + dia + '/' + mes + '/' + anio + '</td>';
                        row += '<td>' + reporte.NombreSucursal + '</td>'; // Añade el nombre de la sucursal (ejemplo)
                        // Agrega más columnas según tu estructura de datos
                        // Agregar tipos de falla
                        var tiposFalla = Array.isArray(reporte.tipos_reporte) ? reporte.tipos_reporte.join(', ') : reporte.tipos_reporte;
                        row += '<td>' + tiposFalla + '</td>';
                        row += '<td>' + obtenerEstadoFormateado(reporte.ultimo_estado) + '</td>'; //
                        var fecha_act = new Date(reporte.ultima_actualizacion);
                        var dia2 = fecha_act.getDate().toString().padStart(2, '0'); // Asegura dos dígitos, rellenando con cero si es necesario
                        var mes2 = (fecha_act.getMonth() + 1).toString().padStart(2, '0'); // Sumar 1 ya que los meses en JavaScript van de 0 a 11
                        var anio2 = fecha_act.getFullYear();
                        row += '<td>' + dia2 + '/' + mes2 + '/' + anio2 + '</td>';
                        var detalle_url = '{{ route('Detalle Reporte', '') }}' + '/' + reporte.ID_Reporte;
                        row += '<td> <a class="btn btn-warning material-symbols-outlined text-white" title="Seguimiento" href="' + detalle_url + '">info</a> <td>';

                        tbody.append(row);
                    });
                    
                } else {
                    tbody.append('<tr><td colspan="7">No se encontraron resultados</td></tr>');
                }
                
            }
            function obtenerEstadoFormateado(estado) {
        switch (estado) {
            case 'DS':
                return 'Derivado a Soporte';
            case 'DJT':
                return 'Derivado a Jefe de Técnicos';
            case 'DT':
                return 'Visita Técnica agendada';
            case 'DC':
                return 'Derivado a cliente';
            case 'TE':
                return 'Derivado a Técnico Externo';
            case 'DAC':
                return 'Derivado a Área Comercial';
            case 'F':
                return 'Finalizado';
            default:
                return 'Desconocido';
        }
    }
        });
        
    </script>
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
@stop


@endsection