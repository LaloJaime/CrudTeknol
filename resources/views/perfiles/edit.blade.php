Sección para editar perfiles

<form action="{{ url('/perfiles/'.$perfil->id) }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
{{ method_field('PATCH') }}

<label for="Nombre">{{'Nombre'}}</label>
<input type="text" name="Nombre" id="Nombre" value="{{$perfil->Nombre}}">
<br>

<label for="Apellido">{{'Apellido'}}</label>
<input type="text" name="Apellido" id="Apellido" value="{{$perfil->Apellido}}">
<br>

<label for="Localidad">{{'Localidad'}}</label>
<input type="text" name="Localidad" id="Localidad" value="{{$perfil->Localidad}}">
<br>

<label for="FechaDeNacimiento">{{'Fecha de nacimiento'}}</label>
<input type="date" name="FechaDeNacimiento" id="FechaDeNacimiento" value="{{$perfil->FechaDeNacimiento}}" min="1900-01-01" >
<br>

<label for="Genero">{{'Género'}}</label>
<select id="Genero" name="Genero">
  <option value="Hombre" <?php if($perfil->Genero == 'Hombre'){echo("selected");}?>>Hombre</option>
  <option value="Mujer" <?php if($perfil->Genero == 'Mujer'){echo("selected");}?>>Mujer</option>
  <option value="Otros" <?php if($perfil->Genero == 'Otros'){echo("selected");}?>>Otros</option>
</select>
<br>

<label for="ImagenDePerfil">{{'Imagen de perfil'}}</label>
<br>
<img src="{{ asset('storage').'/'.$perfil->ImagenDePerfil }}" alt="" width="200">
<br>
<input type="file" name="ImagenDePerfil" id="ImagenDePerfil" value="">
<br>
<input type="submit" value="Editar">
<a href="{{ url('perfiles') }}">Regresar</a>
</form>