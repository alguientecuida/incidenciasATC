
@extends('master.master')
@section('contenido_principal')



<body>
   
    <div class='container-fluid mt-5'>
        <div class="row">
            <div class="col"></div>
            <div class="container col m-3">
                <div class="card text-center">
                    <div class="card-header">
                      <h3>Crear ODT</h3>
                    </div>
                    <form method="POST" action="#">
                    @csrf
                    <div class="card-body">
                        
                        <p>Selecciona la sucursal par ODT:</p>
                        <select class="js-example-basic-single" name="sucursal" placeholder='Seleccionar sucursal'>
                            <option value="" disabled style="display:none;" selected >Elegir una opción</option>
                            @foreach($sucursales as $sucursal)
                                <option value="{{ $sucursal->ID }}">{{ $sucursal->NOMBRE_SUCURSAL }}</option>
                            @endforeach
                        </select>
                        <hr class="border-warning">
                        <p>Selecciona el técnico que será asignado:</p>
                        <select class="js-example-basic-single" name="tecnico" placeholder='Seleccionar técnico'>
                            <option value="" disabled style="display:none;" selected >Elegir una opción</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->ID }}">{{ $tecnico->NOMBRE }}</option>
                            @endforeach
                        </select>
                        <hr class="border-warning">
                        <div>
                            <p for="observacion" class="form-label">Seleccione el tipo de trabajo:</p>
                            <select class="js-example-basic-single" name="trabajo" placeholder='Seleccionar técnico'>
                                <option value="" disabled selected style="display:none;">Elegir una opción</option>
                                <option value="I">Instalación</option>
                                <option value="D">Desinstalación</option>
                                <option value="MC">Mantención Correctiva</option>
                                <option value="MPV">Mantención Preventiva</option>
                                <option value="MPD">Mantención Predictiva</option>
                            </select>
                        </div>
                        

                    </div>
                    <div class="card-footer text-body-secondary">
                        <button id="registrar-btn" class="btn btn-warning text-center" type="submit">Crear reporte</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col">
                
            </div>
        </div>
    </div>
</body>

@endsection



@section('js')
    <script>
        $('.js-example-basic-single').select2({
        });

        $('.js-example-basic-multiple').select2({
        });
    </script>
@stop