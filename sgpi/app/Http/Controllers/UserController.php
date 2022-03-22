<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Jetstream\Rules\Role as RulesRole;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();
        return view('user.index')->with( 'users' , $users);
    }

 
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('user.edit', compact('user','roles'));
    }

 
    public function update(Request $request, User $user)
    {
        return view('user.edit', compact('user','roles'));
        //$user->roles()->sync($request->roles);

        //return redirect()->route('user.edit', $user)->with('info','Se asignaron los roles correctamente');
    }

}
