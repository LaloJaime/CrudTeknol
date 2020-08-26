inicio (despliegue de datos)
<a href="{{ url('perfiles/create') }}">Agregar Perfil</a>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Imagen de perfil</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Localidad</th>
            <th>Fecha de nacimiento</th>
            <th>Género</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($perfiles as $perfil)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <img src="{{ asset('storage').'/'.$perfil->ImagenDePerfil }}" alt="" width="200">
                
            </td>
            <td>{{ $perfil->Nombre }}</td>
            <td>{{ $perfil->Apellido }}</td>
            <td>{{ $perfil->Localidad }}</td>
            <td>{{ $perfil->FechaDeNacimiento }}</td>
            <td>{{ $perfil->Genero }}</td>
            <td>
                <a href="{{ url('/perfiles/'.$perfil->id.'/edit')}}">Editar</a>
                 | 
                <form action="{{ url('/perfiles/'.$perfil->id) }}" method="post">
                {{ csrf_field() }} 
                {{ method_field('DELETE') }}
                <button type="submit" onclick="return confirm('¿Borrar?')">Borrar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>