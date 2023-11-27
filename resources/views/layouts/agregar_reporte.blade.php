
@extends('master.master')
@section('contenido_principal')



<body>
   
    <div class='container-fluid mt-5'>
        <div class="row">
            <div class="col"></div>
            <div class="container col m-3">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <p>Por favor solucione los siguientes problemas</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card text-center">
                    <div class="card-header">
                      <h3>Agregar Reporte</h3>
                    </div>
                    <form method="POST" action="{{route('agregar.reporte')}}">
                    @csrf
                    <div class="card-body">
                        
                        <p>Selecciona la sucursal que quiere reportar:</p>
                        <select class="js-example-basic-single" name="sucursal" placeholder='Seleccionar sucursal'>
                            <option value="" disabled selected style="display:none;">Elegir una opción</option>
                            @foreach($sucursales as $sucursal)
                                <option value="{{ $sucursal->ID }}">{{ $sucursal->NOMBRE_SUCURSAL }}</option>
                            @endforeach
                        </select>
                        <hr class="border-warning">
                        <p>Selecciona la/s fallas que presenta la sucursal:</p>
                        <select class="js-example-basic-multiple" name="tipos[]" multiple="multiple">
                            @foreach($tipos_fallas as $tipo_falla)
                                <option value="{{ $tipo_falla->ID_Falla }}">{{ $tipo_falla->tipo }}</option>
                            @endforeach
                        </select>
                        <hr class="border-warning">
                        <div>
                            <label for="observacion" class="form-label">Ingrese la observación</label>
                            <textarea class="form-control textarea" id="observacion" name='observacion' rows="3" placeholder='Ingrese numero de cámara, equipo o indicaciones del cliente...'></textarea>
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
    <script>
        history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                history.go(1);
            };
    </script>}
    <script>
        window.addEventListener('beforeunload', function (event) {
            // Cancelar el evento de descarga (mostrar la confirmación al usuario)
            event.preventDefault();
            // Mensaje que se mostrará al usuario
            var confirmationMessage = '¿Seguro que deseas abandonar la página? Los cambios no se guardarán.';
            // Establecer el mensaje en algunos navegadores
            event.returnValue = confirmationMessage;
            // Devolver el mensaje en otros navegadores
            return confirmationMessage;
        });
    
        // Función para desvincular el evento beforeunload si el formulario se envía
        function handleFormSubmit() {
            window.removeEventListener('beforeunload', beforeUnloadHandler);
        }
    </script>
@stop