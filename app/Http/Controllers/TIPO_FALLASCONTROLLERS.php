<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TIPO_FALLA;
use Illuminate\Support\Facades\DB;

class TIPO_FALLASCONTROLLERS extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$tipos_fallas = DB::table('TIPOS_FALLAS')
        //->select('ID_Falla', 'tipo')
        //->get();

        //return view('layouts.agregar_reporte', ['tipos_fallas' => $tipos_fallas]);
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
    public function store(Request $request)
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
}
