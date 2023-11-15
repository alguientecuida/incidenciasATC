<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF ODT N° {{$odt->Numero_odt}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
      /* Define el tamaño del texto para la clase de párrafo específica */
      .parrafo-personalizado {
          font-size: 12px; /* Puedes ajustar el valor según tus necesidades */
      }
      .borde-negro {
            border: 1px solid #000; /* 1px de ancho, sólido y negro (#000) */
            padding: 30px; /* Añade un poco de espacio interno para mayor claridad */
            min-height: 100px;
            
        }
        .borde-negro-der {
            border: 1px solid #000; /* 1px de ancho, sólido y negro (#000) */
            padding: 30px; /* Añade un poco de espacio interno para mayor claridad */
            
        }
        .tabla {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;

        }

        .fila {
            display: table-row;
        }

        .celda {
            display: table-cell;
            padding: 15px;
            border: 1px solid #000;
            
        }

        .celda:first-child {
            font-weight: bold;
            width: 28%; /* La primera celda se ajusta al largo del texto */
        }
        .celda:not(:first-child) {
            width: 100%; /* Toma el ancho restante de la tabla */
        }

        .celda2 {
            display: table-cell;
            padding: 15px;
            border: 1px solid #000;
            
        }

        .celda2:first-child {
            font-weight: bold;
            width: 35%; /* La primera celda se ajusta al largo del texto */
        }
        .celda2:not(:first-child) {
            width: 100%; /* Toma el ancho restante de la tabla */
        }

        .pdf{
          font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        @page {
          margin: 100px 25px;
        }

        header {
          position: fixed;
          left: 0px;
          top: -60px;
          height: 50px;
          right: 0px;
        }   
        footer{
          position: fixed;
          bottom: 0px;
          right: 0px;
          left: 0px;
          height: 0px;
          font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
          font-size: 9px;
 
          
        }
        
  </style>
  </head>
  <body>
  <header class='pdf'>
    <img src="{{$logo}}">
    <p class='text-end'>N° <span style="color: red;">{{ $odt->Numero_odt }}</span></p>
    <p class="text-end parrafo-personalizado">Fecha {{ \Carbon\Carbon::parse($odt->Fecha_cierre)->format('d/m/Y') }}</p>

  </header>
  <footer class="text-end">
    <hr>
    <p>Alguien te Cuida SpA</p>
    <p>www.alguientecuida.cl</p>
    <p>600 828 8000</p>
    <p>Av. Colón 2864-A, Valparaíso</p>
  </footer>

    <div class="mt-5">

  <main>
    <p class="text-center pb-3 pdf"><b>ASIGNACIÓN DE TRABAJO</b></p>
          
        

        <div class="tabla" id='tabla1'>
          <div class="fila">
              <div class="celda pdf">Nombre de Técnico</div>
              <div class="celda pdf">@foreach($odt->usuarioAsig as $asignacion)
                {{$asignacion->NOMBRE}}@endforeach</div> <!-- Segunda celda sin contenido inicial -->
          </div>
          <div class="fila">
              <div class="celda pdf">Persona de contacto</div>
              <div class="celda pdf">{{$odt->persona_contacto}}</div> <!-- Segunda celda sin contenido inicial -->
          </div>
          <div class="fila pdf">
              <div class="celda">Teléfono de contacto</div>
              <div class="celda">{{$odt->numero_contacto}}</div> <!-- Segunda celda sin contenido inicial -->
          </div>
          <!-- Agrega más filas según sea necesario -->
      </div>

      <div class="tabla pdf" id='tabla2'>
        <div class="fila">
            <div class="celda2">RUT Cliente</div>
            <div class="celda2">{{$cliente->RUT}}</div> <!-- Segunda celda sin contenido inicial -->
        </div>
        <div class="fila">
            <div class="celda2">Nombre cliente o empresa</div>
            <div class="celda2">{{$cliente->NOMBRE_CLIENTE}}</div> <!-- Segunda celda sin contenido inicial -->
        </div>
        <div class="fila">
            <div class="celda2">Dirección o ID GoogleMaps</div>
            <div class="celda2">{{$odt->sucursal->DIRECCION}}</div> <!-- Segunda celda sin contenido inicial -->
        </div>
        <div class="fila">
          <div class="celda2">Tipo de trabajo</div>
          <div class="celda2">@if($odt->Tipo_trabajo == "MC") Mantención Correctiva
            @elseif($odt->Tipo_trabajo == "MPD") Mantención Predictiva
            @elseif($odt->Tipo_trabajo == "MPV") Mantención Preventiva
            @elseif($odt->Tipo_trabajo == "I") Instalación
            @elseif($odt->Tipo_trabajo == "D") Desinstalación
            @endif</div> <!-- Segunda celda sin contenido inicial -->
      </div>
      <div class="fila">
        <div class="celda2">Fecha de inicio trabajo</div>
        <div class="celda2">{{ \Carbon\Carbon::parse($odt->Fecha_inicio)->format('d/m/Y') }}</div> <!-- Segunda celda sin contenido inicial -->
    </div>
        <!-- Agrega más filas según sea necesario -->
    </div>

    <div class="p-2 borde-negro pdf">
      <p></p>
      <b class="pt-5">Descripción trabajo</b>
      <p class="pt-3">{{$odt->Detalle_cierre}}</p>
    </div>
    
      
      @if($imagenes)
      <div class="pt-3">
      <p><b class="p-3 pdf">Imágenes</b></p>
        @foreach ($imagenes as $imagen)
          <img src="{{$imagen}}" class="m-1">
        @endforeach
      </div>
      @endif
   
  </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  
  </main>
  
</body>

</html>

