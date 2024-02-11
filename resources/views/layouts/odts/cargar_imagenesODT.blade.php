
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
                        <H3>Cargar Imagenes </H3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('guardar.imagenInd', $ID_odt)}}"
                        class="dropzone" 
                        id="my-great-dropzone"
                        method="POST"> 
                    </form>
                    <h6><b>*IMPORTANTE: Elegir bien la imagen una vez subida no se pueden eliminar.</b></h6>
                    </div>
                    <div class="card-footer text-body-secondary">
                        <button id="registrar-btn" class="btn btn-warning text-center" type="submit">LISTO!</button>
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
        Dropzone.options.myGreatDropzone = { // camelized version of the `id`
          headers:{
              'X-CSRF-TOKEN' : "{{csrf_token()}}"
          },
          dictDefaultMessage:"Arrastrar o apretar para cargar las imagenes referentes al trabajo a realizar"
        };
      </script>
    
    
@stop