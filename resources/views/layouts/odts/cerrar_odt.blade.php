@extends('master.master')
@section('contenido_principal')

<div class='container-fluid mt-5'>
    <div class="row">
        <div class="col"></div>
        <div class="col m-3">
            <div class="card text-center">
                <div class="card-header">
                  <h3>Cerrar ODT</h3>
                </div>
                
                {{--<form action="{{route('guardar.imagen',  $id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file" id="" accept="image/*">
                    </div>
                    
                    <button type="submit">Subir imagen</button>
                </form>--}}
                <H3>Cargar Imagenes</H3>
                <div class="card-body">
                    <form action="{{route('guardar.imagen',  $id)}}"
                    class="dropzone" 
                    id="my-great-dropzone"
                    method="POST"> 
                </form>
                <h6><b>*IMPORTANTE: Elegir bien la imagen una vez subida no se pueden borrar.</b></h6>
                </div>
                <div class="card-body">
                    <form action="{{route('cerrar.odt',  $id)}}" method="POST">
                    @csrf
                    <label for="observacion" class="form-label">Ingrese Detalle del cierre de ODT</label>
                    <textarea class="form-control textarea" id="detalle" name='detalle' rows="4" placeholder='Ingrese la descripción del trabajo'></textarea>

                    <label for="nombre_contacto">Ingrese el nombre de la perosna que lo recibió</label>
                    <div>
                    <input type="text" name="nombre_contacto" id="nombre_contacto" class="form-control text-center" placeholder="Nombre de la persona que lo recibió">
                    </div>
                    <label for="numero_contacto">Ingrese el numero de celular de la persona que lo recibió</label>
                    <input type="text" class="form-control text-center" name="numero_contacto" id="numero_contacto" placeholder="912345678">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Cerrar ODT</button>
                </div>
                </form>
                
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>

@section('js')

<script>
  Dropzone.options.myGreatDropzone = { // camelized version of the `id`
    headers:{
        'X-CSRF-TOKEN' : "{{csrf_token()}}"
    },
    dictDefaultMessage:"Arrastrar o apretar para cargar las imagenes correspondientes a la ODT"
  };
</script>
@stop


@endsection