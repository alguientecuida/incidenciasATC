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
                      <h3>Reasignar ODT</h3>
                    </div>
                    <form method="POST" action="{{route('reasignar.odt', $asignacion->ID_asignacion)}}">
                    @csrf
                    <div class="card-body">
                    
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <h5 class='col'>
                                    ID ODT: 
                                </h5>
                            </div>
                            <div class="col-3">
                                <input name='sucursal' class="form-control col" type="text" disabled aria-label="default input example" value="{{$odt->ID_odt}}">
                            </div>
                          </div>
                        
                        <hr class="border-warning">
                        <p>Técnico a cual reasignara la ODT:</p>
                        <select class="js-example-basic-single" name="tecnico" placeholder='Seleccionar técnico a asignar odt'>
                            <option value="" disabled selected style="display:none;">Elegir una opción</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->ID }}">{{ $tecnico->NOMBRE }}</option>
                            @endforeach
                        </select>

                        
    
                    </div>
                    <div class="card-footer text-body-secondary">
                        <button id="registrar-btn" class="btn btn-warning text-center" type="submit">Reasignar ODT</button>
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
