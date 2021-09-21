<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $title="Profile";
        $tab="profile";
        $detail=Auth::user();
        return view('admin/profile/profile',compact('title','tab','detail'));
    }

    public function profile_validation(Request $request){
        $update_id=Auth::user()->id;

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$update_id]
        ]);
        $user = User::find($update_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->update();

        return redirect()->route('admin.profile',app()->getLocale())
            ->with('status', 'Data updated successfully');
    }
}
