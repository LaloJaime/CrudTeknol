<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfiles;
use Illuminate\Support\Facades\Storage;

class ApiPerfiles extends Controller
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
    public function store(Request $request)
    {
        //
        $datosPerfil=request()->all();
        if (!request()->ImagenDePerfil || !request()->Nombre || !request()->Apellido || !request()->Localidad || !request()->FechaDeNacimiento || !request()->Genero) {
			return response()->json(['errors'=>array(['code'=>400,'message'=>'Faltan datos necesarios para procesar el alta.'])],400);
		}
        if (!$datosPerfil['ImagenDePerfil'] || !$datosPerfil['Nombre'] || !$datosPerfil['Apellido'] || !$datosPerfil['Localidad'] || !$datosPerfil['FechaDeNacimiento'] || !$datosPerfil['Genero']) {
			return response()->json(['errors'=>array(['code'=>400,'message'=>'Faltan datos necesarios para procesar el alta.'])],400);
		}
        if (!preg_match('/^data:image\/(\w+);base64,/', $datosPerfil['ImagenDePerfil'])) {
            return response()->json(['errors'=>array(['code'=>400,'message'=>'La imagen necesita estar en formato base64.'])],400);
        }
        if (strlen($datosPerfil['Nombre']) > 100) {
            return response()->json(['errors'=>array(['code'=>400,'message'=>'El nombre solo puede contener 100 caracteres.'])],400);
        }
        if (strlen($datosPerfil['Apellido']) > 100) {
            return response()->json(['errors'=>array(['code'=>400,'message'=>'El Apellido solo puede contener 100 caracteres.'])],400);
        }
        if (strlen($datosPerfil['Localidad']) > 100) {
            return response()->json(['errors'=>array(['code'=>400,'message'=>'La Localidad solo puede contener 100 caracteres.'])],400);
        }
        if (!(bool)strtotime($datosPerfil['FechaDeNacimiento'])) {
            return response()->json(['errors'=>array(['code'=>400,'message'=>'La Fecha no es valida.'])],400);
        }
        if ($datosPerfil['Genero'] != 'Hombre' && $datosPerfil['Genero'] != 'Mujer' ) {
            $datosPerfil['Genero'] = 'Otros';
        }
        $data = substr($datosPerfil['ImagenDePerfil'], strpos($datosPerfil['ImagenDePerfil'], ',') + 1);
        $data = base64_decode($data);
        $tipo = substr($datosPerfil['ImagenDePerfil'], 11, strpos($datosPerfil['ImagenDePerfil'], ';')-11);
        Storage::disk('public')->put("uploads/Perfil".$datosPerfil['Nombre'].$datosPerfil['Apellido'].'.'.$tipo, $data);
        $datosPerfil['ImagenDePerfil'] = 'uploads/Perfil'.$datosPerfil['Nombre'].$datosPerfil['Apellido'].'.'.$tipo;
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
    public function update(Request $request, $id)
    {
        //
        if (request()->ImagenDePerfil || request()->Nombre || request()->Apellido || request()->Localidad || request()->FechaDeNacimiento || request()->Genero) {
            $datosPerfil=request()->all();
            if (request()->ImagenDePerfil && !preg_match('/^data:image\/(\w+);base64,/', $datosPerfil['ImagenDePerfil'])) {
                return response()->json(['errors'=>array(['code'=>400,'message'=>'La imagen necesita estar en formato base64.'])],400);
            }
            if (request()->Nombre && strlen($datosPerfil['Nombre']) > 100) {
                return response()->json(['errors'=>array(['code'=>400,'message'=>'El nombre solo puede contener 100 caracteres.'])],400);
            }
            if (request()->Apellido && strlen($datosPerfil['Apellido']) > 100) {
                return response()->json(['errors'=>array(['code'=>400,'message'=>'El Apellido solo puede contener 100 caracteres.'])],400);
            }
            if (request()->Localidad && strlen($datosPerfil['Localidad']) > 100) {
                return response()->json(['errors'=>array(['code'=>400,'message'=>'La Localidad solo puede contener 100 caracteres.'])],400);
            }
            if (request()->FechaDeNacimiento && !(bool)strtotime($datosPerfil['FechaDeNacimiento'])) {
                return response()->json(['errors'=>array(['code'=>400,'message'=>'La Fecha no es valida.'])],400);
            }
            if (request()->Genero && $datosPerfil['Genero'] != 'Hombre' && $datosPerfil['Genero'] != 'Mujer') {
                $datosPerfil['Genero'] = 'Otros';
            }
            if (request()->ImagenDePerfil) {
                if (!preg_match('/^data:image\/(\w+);base64,/', $datosPerfil['ImagenDePerfil'])) {
                    return response()->json(['errors'=>array(['code'=>400,'message'=>'La imagen necesita estar en formato base64.'])],400);
                }
                $perfil = Perfiles::findOrFail($id);
                Storage::delete('public/'.$perfil->ImagenDePerfil);
                $data = substr($datosPerfil['ImagenDePerfil'], strpos($datosPerfil['ImagenDePerfil'], ',') + 1);
                $data = base64_decode($data);
                $tipo = substr($datosPerfil['ImagenDePerfil'], 11, strpos($datosPerfil['ImagenDePerfil'], ';')-11);
                Storage::disk('public')->put("uploads/Perfil".$perfil['Nombre'].$perfil['Apellido'].'.'.$tipo, $data);
                $datosPerfil['ImagenDePerfil'] = 'uploads/Perfil'.$perfil['Nombre'].$perfil['Apellido'].'.'.$tipo;
            }
            Perfiles::where('id','=',$id)->update($datosPerfil);
            $perfil = Perfiles::findOrFail($id);
            return response()->json($perfil,200); 
            
		} else {
            return response()->json(['errors'=>array(['code'=>400,'message'=>'Se necesita un campo válido para modificar.'])],400);
        }
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
        $perfil = Perfiles::findOrFail($id);
        Storage::delete('public/'.$perfil->ImagenDePerfil);
        Perfiles::destroy($id);
        return response()->json($perfil);
    }
}
