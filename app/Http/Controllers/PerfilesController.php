<?php

namespace App\Http\Controllers;

use App\Perfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['perfiles'] = Perfiles::paginate(5);

        return view('perfiles.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('perfiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $datosPerfil=request()->all();
        $datosPerfil=request()->except('_token');
        if ($request->hasFile('ImagenDePerfil')) {
            $datosPerfil['ImagenDePerfil'] = $request->file('ImagenDePerfil')->store('uploads','public');
        }
        Perfiles::insert($datosPerfil);
        // return response()->json($datosPerfil);
        return redirect('perfiles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perfiles  $perfiles
     * @return \Illuminate\Http\Response
     */
    public function show(Perfiles $perfiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfiles  $perfiles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $perfil = Perfiles::findOrFail($id);
        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfiles  $perfiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $datosPerfil=request()->except(['_token','_method']);
        if ($request->hasFile('ImagenDePerfil')) {
            $perfil = Perfiles::findOrFail($id);
            Storage::delete('public/'.$perfil->ImagenDePerfil);
            $datosPerfil['ImagenDePerfil'] = $request->file('ImagenDePerfil')->store('uploads','public');
        }
        Perfiles::where('id','=',$id)->update($datosPerfil);
        $perfil = Perfiles::findOrFail($id);
        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfiles  $perfiles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $perfil = Perfiles::findOrFail($id);
        if (Storage::delete('public/'.$perfil->ImagenDePerfil)) {
            Perfiles::destroy($id);
        }
        return redirect('perfiles');
    }
}
