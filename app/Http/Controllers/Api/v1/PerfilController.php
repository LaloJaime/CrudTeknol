<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perfiles;
use App\Http\Requests\PerfilRequest;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['perfiles'] = Perfiles::all();
        return response()->json($datos,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerfilRequest $request)
    {
        //
        $datosPerfil=request()->all();
        if ($request->hasFile('imagen_perfil')) {
            $datosPerfil['imagen_perfil'] = $request->file('imagen_perfil')->store('uploads','public');
        }
        Perfiles::insert($datosPerfil);
        return response()->json($datosPerfil,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerfilRequest $request, $id)
    {
        //
        $datosPerfil=request()->all();
        // if ($request->hasFile('imagen_perfil')) {
        //     $datosPerfil['imagen_perfil'] = $request->file('imagen_perfil')->store('uploads','public');
        // }
        // $perfil2 = Perfiles::find($id);
        // if (!$perfil2) {
        //     return response()->json(['errors'=>array(['code'=>400,'message'=>'No se encuentra el Id.'])],400);
        // }
        // $datosPerfil=request()->all();
        // Perfiles::where('id','=',$id)->update($datosPerfil);
        // $perfil = Perfiles::findOrFail($id);
        return response()->json($datosPerfil,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $perfil = Perfiles::find($id);
        if (!$perfil) {
            return response()->json(['errors'=>array(['code'=>400,'message'=>'No se encuentra el Id.'])],400);
        }
        Storage::delete('public/'.$perfil->imagen_perfil);
        Perfiles::destroy($id);
        return response()->json($perfil);
    }
}
