Sección para crear perfiles
<form action="{{ url('/perfiles') }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}

<label for="Nombre">{{'Nombre'}}</label>
<input type="text" name="Nombre" id="Nombre" value="">
<br>

<label for="Apellido">{{'Apellido'}}</label>
<input type="text" name="Apellido" id="Apellido" value="">
<br>

<label for="Localidad">{{'Localidad'}}</label>
<input type="text" name="Localidad" id="Localidad" value="">
<br>

<label for="FechaDeNacimiento">{{'Fecha de nacimiento'}}</label>
<input type="date" name="FechaDeNacimiento" id="FechaDeNacimiento" value="" min="1900-01-01" >
<br>

<label for="Genero">{{'Género'}}</label>
<select id="Genero" name="Genero">
  <option value="Hombre">Hombre</option>
  <option value="Mujer">Mujer</option>
  <option value="Otros">Otros</option>
</select>
<br>

<label for="ImagenDePerfil">{{'Imagen de perfil'}}</label>
<input type="file" name="ImagenDePerfil" id="ImagenDePerfil" value="">
<br>

<input type="submit" value="Agregar">
<a href="{{ url('perfiles') }}">Regresar</a>
</form>