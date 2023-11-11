<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="csrf-token" content="{{csrf_token()}}">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <script src="https://kit.fontawesome.com/6fe936433f.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Iniciar Sesion</title>
      </head>
    <main>
        <body>
           <div class="container">
            <div class="row justify-content-md-center">

            <div class="templatemo-login-widget templatemo-content-widget bg-login text-center">

                <span><img class="img-responsive" src="{{asset('img/LOGO.png')}}"></span>
        
                <form method="POST" action="{{route('USUARIO.LOGIN')}}">

                                    
                    @csrf        
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></div>
                                <input type="text" id="USUARIO" class="form-control" placeholder="RUT" name="USUARIO">
                            </div>    
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></div>
                                    <input type="password" class="form-control" id="PASS_HASH" name="PASS_HASH" placeholder="***********">
                                </div>
                            </div>
                            
                        </div>              
                    <div class="card-footer d-grid gap-1 alpha2">
                        <button type="submit" id="iniciar_sesion-btn" class="btn btn-outline-warning">Inciar Sesion</button>
                    </div>
                    @if($errors->any())
                        <!--<div class="alert alert-danger">
                            <ul class="mb-0">-->
                                <script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Credenciales inconrrectas',
                                    icon: 'error',
                                    confirmButtonText: 'Entendido'
                                  })
                                </script> 
                                
                            <!--</ul>
                        </div>-->
                    @endif
        
                </form>
        

            </div>
            <div class="row mt-5">
                <div class="mt-5">
                    
                </div>
            </div>
            </div> 
           </div>
        </body>
        

        
        
    </main>



</html>