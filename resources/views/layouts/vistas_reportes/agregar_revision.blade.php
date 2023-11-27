@extends('master.master')
@section('contenido_principal')
<style>
    

    #habalitar{
        display: none;
    }

    /* Estilo para ajustar el ancho del input date */
    #Fecha_inicio {
        width: 150px; /* Puedes ajustar el ancho según tus necesidades */
        margin: 0; /* Asegura que no haya margen exterior */
        padding: 4px; /* Añade algún relleno para mejorar la apariencia */
        box-sizing: border-box; /* Puedes ajustar el ancho según tus necesidades */
        
    }

    
</style>
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
                      <h3>Agregar Revisión</h3>
                    </div>
                    <form method="POST" action="{{route('agregar.revision', $reporte->ID_Reporte)}}" onsubmit="handleFormSubmit()">
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
                          <h5 class='col'>
                            NOMBRE SUCURSAL: 
                        </h5>
                            <input class="form-control text-center" type="text" disabled aria-label="default input example" value="{{$reporte->sucursal->NOMBRE_SUCURSAL}}">

                        
                        <hr class="border-warning">
                        <p>Cambio de estado:</p>
                        <select class="js-example-basic-single" name="estado" id='estado' onchange="habilitarSelect()">
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
                        

                        <div id='habilitar' style="display: none;">
                        <hr class="border-warning">
                        <p>Técnico a cual asignara ODT:</p>
                        <select name="tecnico" id="tecnico" class="js-example-basic-single" disabled>
                            <option value="" disabled selected style="display:none;">Elegir una opción</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->ID }}">{{ $tecnico->NOMBRE }}</option>
                            @endforeach
                        </select>

                        <hr class="border-warning">
                        <p>Fecha de la visita:</p>
                        <input type="date" name="Fecha_inicio" id="Fecha_inicio" disabled>
                    </div>


                        <hr class="border-warning">
                        <div>
                            <label for="observacion" class="form-label">Ingrese la observación </label>
                            <textarea class="form-control textarea" id="observacion" name='observacion' rows="4" placeholder='Ej: Se conecto remotamente a un computador del lugar y no se pudo solucionar..'></textarea>
                        </div>
                        
                        
                    </div>
                    
                    <hr class="border-warning">
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

<script>
    function habilitarSelect() {
        var select1 = document.getElementById("estado");
        var select2 = document.getElementById("tecnico");
        var Fecha_inicio = document.getElementById("Fecha_inicio");
        var habilitar = document.getElementById('habilitar');

 // Ocultar con Select
        
        
        // Habilitar el segundo select si se selecciona una opción en el primer select
        if (select1.value == "DT") {
            habilitar.disabled = false;
            habilitar.style.display = 'block';
            select2.disabled = false;
            Fecha_inicio.disabled = false;

        } else {
            habilitar.disabled = true;
            habilitar.style.display = "none";
            
            // Deshabilitar y ocultar el segundo select si no se selecciona ninguna opción en el primer select
            select2.disabled = true;

            select2.style.display = "none";

            Fecha_inicio.disabled = true;

            

        }
        
    }
    
</script>


<script>
    history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            history.go(1);
        };
</script>
<script>
    function beforeUnloadHandler(event) {
            // Cancelar el evento de descarga (mostrar la confirmación al usuario)
            event.preventDefault();
            // Mensaje que se mostrará al usuario
            var confirmationMessage = '¿Seguro que deseas abandonar la página? Los cambios no se guardarán.';
            // Establecer el mensaje en algunos navegadores
            event.returnValue = confirmationMessage;
            // Devolver el mensaje en otros navegadores
            return confirmationMessage;
        }

        window.addEventListener('beforeunload', beforeUnloadHandler);

        // Función para desvincular el evento beforeunload cuando el formulario se envía
        function handleFormSubmit() {
            window.removeEventListener('beforeunload', beforeUnloadHandler);
        }
</script>
@stop
@endsection