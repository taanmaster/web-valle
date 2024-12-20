<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Creado</th>
                <th>Actualizado</th>
                @if($users->count() > 1)
                    <th scope="col">Acciones</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">#{{ $user->id }}</th>
                <td>
                    <a href="{{ route('users.show', $user->id) }}">
                        @if( $user->image == NULL)
                        <img class="thumb-md rounded-circle mr-2" src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?d=retro&s=200' }}" width="25px" alt="{{ $user->name }}">
                        @else
                        <img  class="thumb-md rounded-circle mr-2" src="{{ asset('img/users/' . $user->image ) }}" width="25px" alt="{{ $user->name }}">
                        @endif
                        {{ $user->name }}
                    </a>
                </td>
                <td>{{ $user->email }}</td>

                <td>{{ $user->getRoleNames() }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>

                @if($users->count() > 1)
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            {{--  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i></a> --}}

                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display: inline-block;">
                                <button type="submit" class="btn btn-sm btn-icon">
                                    <i class='bx bx-trash-alt text-danger'></i> Eliminar
                                </button>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </td> 
                @endif
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
 