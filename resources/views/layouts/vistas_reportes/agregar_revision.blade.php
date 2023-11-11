@extends('master.master')
@section('contenido_principal')

<body>
    <div class='container-fluid mt-5'>
        <div class="row">
            <div class="col"></div>
            <div class="container col m-3">
                <div class="card text-center">
                    <div class="card-header">
                      <h3>Agregar Revisión</h3>
                    </div>
                    <form method="POST" action="{{route('agregar.revision', $reporte->ID_Reporte)}}">
                    @csrf
                    <div class="card-body">
                    
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <h5 class='col'>
                                    ID REPORTE: 
                                </h5>
                            </div>
                            <div class="col-3">
                                <input class="form-control col" type="text" disabled aria-label="default input example" value="#{{$reporte->ID_Reporte}}">
                            </div>
                          </div>
                        
                        <hr class="border-warning">
                        <p>Cambio de estado:</p>
                        <select class="js-example-basic-single" name="estado">
                            <option value="" disabled selected >Elegir una opción</option>
                            @if ($revision->Estado !== 'DS')
                            <option value="DS">Derivar a Soporte Técnico</option>
                            @endif
                            @if ($revision->Estado !== 'DJT')
                            <option value="DJT">Derivar al Jefe de Técnicos</option>
                            @endif
                            @if ($revision->Estado !== 'DT' AND session('usuario')['TIPO'] == 'Jefe Tecnico')
                            <option value="DT">Derivar a Técnico</option>
                            @endif
                            @if ($revision->Estado !== 'DC')
                            <option value="DC">Derivar al cliente</option>
                            @endif
                            @if ($revision->Estado !== 'TE')
                            <option value="TE">Derivar a Técnico Externo</option>
                            @endif
                            @if ($revision->Estado !== 'DAC')
                            <option value="DAC">Derivar a Area Comercial</option>
                            @endif
                            @if ($revision->Estado !== 'F')
                            <option value="F">Finalizado</option>
                            @endif
                        </select>
                        <hr class="border-warning">
                        <div>
                            <label for="observacion" class="form-label">Ingrese la observación </label>
                            <textarea class="form-control textarea" id="observacion" name='observacion' rows="4" placeholder='Ej: Se conecto remotamente a un computador del lugar y no se pudo solucionar..'></textarea>
                        </div>
                        
    
                    </div>
                    <div class="card-footer text-body-secondary">
                        <button id="registrar-btn" class="btn btn-warning text-center" type="submit">Agregar revisión</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col">
                
            </div>
        </div>
    </div>
</body>


@section('js')
    <script>
        $('.js-example-basic-single').select2({
        });

        $('.js-example-basic-multiple').select2({
        });
    </script>
@stop
@endsection