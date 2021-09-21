<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tab="users";
        $title="Users list";
        $list=User::all();
        return view('users/list',compact('tab','title','list'));
    }

    public function edit($id)
    {
        return view('users/edit',["detail"=>User::find($id)]);
    }

    public function save(Request $request)
    {
        $update_id=$request['id'];

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$update_id]
        ]);
        $user = User::find($update_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->update();

        return redirect()->route('users_list')
            ->with('status', 'Data updated successfully');
    }
}
