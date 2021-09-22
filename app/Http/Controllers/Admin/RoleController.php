<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tab="role";
        $title="Roles List";
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('admin.roles.index',compact('tab','title','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lng,$id)
    {
        $tab="role";
        $title="Role Data";
        
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('admin.roles.show',compact('tab','title','role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lng,$id)
    {
        $tab="role";
        $title="Edit Role Permission";

        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.form',compact('tab','title','role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$lng,$id)
    {
        try {
            Log::info('Start code for the update roles.');
            DB::beginTransaction();
            $role = Role::find($id);
            if($request->input('permission')){
                $role->syncPermissions($request->input('permission'));
            }
            DB::commit();
            Log::info('End code for the update roles.');

            notify()->success("Roles has been updated successfully.", "Success", "topRight");
            return redirect()->route('admin.roles.index',app()->getLocale());
        } catch (Exception $exception) {
            DB::rollBack();
            Log::info('Exception code for the update roles.');
            Log::info($exception);

            notify()->error("Failed to update roles", "Error", "topRight");
            return redirect()->route('admin.roles.index',app()->getLocale());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lng,$id){
    }
}
