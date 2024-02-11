<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{Route::current()->getName()}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/master_style.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css " rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js "></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link src="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://kit.fontawesome.com/6fe936433f.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/tab-vertical.js') }}"></script>
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon"/>
    @yield('css')



  </head>
  <header>
    <nav class="navbar navbar-expand-lg bg-nav center">
      <div class="container-fluid">
            <a href="{{route('Reportes General')}}"><img src="{{asset('img/LOGO.png')}}" alt="Alguien Te Cuida" max-width= '100%'; height="80"></a>
          <button class="navbar-toggler blanco" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon blanco"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse col-7 pb-0" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item mt-2 pb-0">
                <div class="dropdown nav-link bg-nav">
                  <a class="dropdown-toggle nav-link {{ Route::currentRouteName() == 'Reportes General' || Route::currentRouteName() == "Reportes Finalizados" 
                  || Route::currentRouteName() == "Reportes Derivado a Soporte" || Route::currentRouteName() == 'Reportes Derivado a Jefe Tecnico' ? 'active' : '' || Route::currentRouteName() == 'Reportes Derivado a Tecnicos' ? : ''}}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Route::currentRouteName() == 'Reportes General' || Route::currentRouteName() == "Reportes Finalizados" || Route::currentRouteName() == "Reportes Derivado a Soporte" || Route::currentRouteName() == 'Reportes Derivado a Jefe Tecnico' || Route::currentRouteName() == 'Reportes Derivado a Tecnicos'
                    || Route::currentRouteName() == 'Reportes Derivado a Clientes')
                      {{Route::current()->getName()}}
                    @else
                      Reportes
                    @endif
                    
                  </a>
                  <ul class="dropdown-menu bg-nav">
                    <li><a class="nav-link {{ Route::currentRouteName() == 'Reportes General' ? 'active' : '' }}" aria-current="page" href="{{route('Reportes General')}}">Reportes General</a></li>
                    <li><a class="nav-link {{ Route::currentRouteName() == "Reportes Derivado a Soporte" ? 'active' : '' }}" href="{{route('Reportes Derivado a Soporte')}}">Reportes Derivado a Soporte</</li>
                    <li><a class="nav-link {{ Route::currentRouteName() == 'Reportes Derivado a Jefe Tecnico' ? 'active' : '' }}" href="{{route('Reportes Derivado a Jefe Tecnico')}}">Reportes Derivado a Jefe Tecnico</</li>
                    <li><a class="nav-link {{ Route::currentRouteName() == "Reportes Derivados a Tecnicos" ? 'active' : '' }}" href="{{route('Reportes Derivado a Tecnicos')}}">Reportes Derivado a Tecnicos</</li>
                    <li><a class="nav-link {{ Route::currentRouteName() == 'Reportes Derivado a Clientes' ? 'active' : '' }}" href="{{route('Reportes Derivado a Clientes')}}">Reportes Derivado a Cliente</</li>
                    <li><a class="nav-link {{ Route::currentRouteName() == "Reportes Finalizados" ? 'active' : '' }}" href="{{route('Reportes Finalizados')}}">Reportes Finalizados</</li>
                    
                  
                  </ul>
                </div>
                
              </li>
              <li class="nav-item pe-3">
                <a class="nav-link {{ Route::currentRouteName() == 'Agregar Reporte' ? 'active' : '' }}" href="{{route('Agregar Reporte')}}">Agregar Reporte</a>
                @if(session('usuario')['TIPO'] == 'Soporte')
                <li class="nav-item pe-3 mt-3">
                <a class="nav-link {{ Route::currentRouteName() == "Reportes Locales" ? 'active' : '' }}" href="{{route("Reportes Locales")}}">Reportes Locales</a>
              </li>
                @endif
              </li>
              <li class="nav-item pe-5 mt-3 pb-0">
                
                @if(session('usuario')['TIPO'] != 'Tecnico')
                <a class="nav-link {{ Route::currentRouteName() == "ODT'S" ? 'active' : '' }}" href="{{route("ODT'S")}}">ODT's</a>
                @elseif(session('usuario')['TIPO'] = 'Tecnico')
                <a class="nav-link {{ Route::currentRouteName() == "ODT'S Tecnicos" ? 'active' : '' }}" href="{{route("ODT'S Tecnicos")}}">Mis ODT's</a>
                @endif
              </li>
              @if(session('usuario')['TIPO'] != 'Tecnico' && session('usuario')['TIPO'] == 'Soporte' || session('usuario')['TIPO'] == 'Jefe Tecnico')
              <li class="pe-5 mt-3">
                
                    <a class="nav-link {{ Route::currentRouteName() == "ODT'S Tecnicos" ? 'active' : '' }}" href="{{route("ODT'S Tecnicos")}}">Mis ODT's</a>
              </li>
              @endif
            </ul>
        </div>
        <div class="navbar-collapse row g-0 col-2 text-white" id="navbarNav">

                    Sesion de: {{session('usuario')['NOMBRE']}} <br>
                    Permisos como: {{session('usuario')['TIPO']}}
                    
                    <a href="{{ route('logout')}}" class='blanco nav-link' style='display: inline !important;'>
                      Cerrar sesión</a>

        </div>
      </nav>
  </header>

  <body>

    @yield('contenido_principal')



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/cdb.min.js"></script>
    <script src="{{ asset('js/tabla-reportes.js') }}"></script>
    <script src="{{ asset('js/ordenar-tabla-reportes.js') }}"></script>
    @yield('js')
  </body>
</html>