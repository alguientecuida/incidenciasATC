<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\{Auth, Hash};
use App\Models\USUARIO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class USUARIOS extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = USUARIO::all();
        return $usuarios;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function USUARIO()
{
    return 'USUARIO';
}

    /*
    public function login(Request $request){
        $credenciales = $request->only('USUARIO', 'password');
        //dd(['USUARIO'=>$request->USUARIO, 'password'=>$request->password]);
        if(Auth::attempt(['USUARIO'=>$request->USUARIO, 'password'=>$request->password])){
            $usuario = USUARIO::where('USUARIO',$request->USUARIO)->first();
            return view('layouts.home');
        }else{
            return back()->withErrors('Credenciales incorrectas.');
        }
    }*/

    /*
    public function usuarios(){
        $usuarios = 
        return $usuarios;
    }*/
    public function login(Request $request){
        $USER = $request->only('USUARIO');
        $PASS_HASH_1 = $request->only('PASS_HASH');
        $PASS_HASH = implode($PASS_HASH_1);
        $us = implode($USER);
        $usuario = $result = DB::select("SELECT * FROM USUARIOS WHERE USUARIO = ? AND CONTRASEÑA = ? AND ESTADO = 'Activado'", [$us, $PASS_HASH]);
        
        if($usuario){
            $us_mostrar = USUARIO::where('USUARIO',$request->USUARIO)->first();
            //$usuario = USUARIO::where('USUARIO', $USER);
            Auth::loginUsingId($us_mostrar->ID);
            //session(['usuarios' => $us_mostrar]);
            //return redirect()->route('Agregar Reporte');
            view()->share('usuario', $usuario);
            if(Auth::check()){
                session(['usuario'=> $us_mostrar]);
                return redirect()->route('Reportes General');
                //dd(session('usuario'));
            }else{
                echo('pal loli perrito');
            }
        
            //dd($usus);
        }else{
            return back()->withErrors('Credenciales Incorrectas');;
        }
        /*
        $credentials = [
            'USUARIO' => $request->input('USUARIO'),
            'PASS_HASH' => $request->input('PASS_HASH'),
        ];
        $credenciales = $request->only('USUARIO', 'PASS_HASH');
        //dd(['USUARIO'=>$request->USUARIO, 'password'=>$request->password]);
        if(Auth::attempt($credenciales)){
            $usuario = USUARIO::where('USUARIO',$request->USUARIO)->first();
            return view('layouts.home');
        }else{
            dd(Auth::attempt($credentials));
            //return back()->withErrors('Credenciales incorrectas.');
        }*/
        
    }

    public function mostrarVista(){
        $usuario = Auth::user();
        return view('master.master', ['usuario' => $usuario]);
    }

    public function logout(){
        session()->forget('usuario');

        return redirect()->route('login');
    }
    
}
