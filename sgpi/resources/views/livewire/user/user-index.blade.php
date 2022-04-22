<div>
    <div class="card">
        <div class="card-header">
            <input wire:model="search" class="form-control" placeholder="Ingrese el nombre o correo de un usuario">
        </div>

        <div class="card-body">
            <table class="table table-hover table-striped table-bordered rounded">
                <thead class="tabla">
                    <tr>
                        <th style="width: 5%" scope="col">ID</th>
                        <th style="width: 30%" scope="col">Nombre</th>
                        <th style="width: 30%" scope="col">Email</th>
                        <th style="width: 5%" scope="col"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                    <a href="{{route('user.edit',$user)}}" class="btn btn-info block">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{$users->links()}}
        </div>
    </div>
</div>
