<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RoleStoreRequest;
use App\Http\Requests\Api\Auth\RoleUpdateRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
// use Spatie\Permission\Traits\HasRoles;


class RoleAndPermissionController extends Controller
{
    // use HasRoles;
        public function __construct()
    {
        $this->middleware(['role:admin',]);
    }

    public function index(){
        $roles=Role::all();
        return response()->json(['success'=>true,'roles'=>$roles],200);
    }

    public function allpermissions(){
        $permissions=Permission::all();
        return response()->json(['success'=>true,'permissions'=>$permissions],200);
    }

    public function editerole(Role $role){
        $role->permissions;
        $permissions=Permission::all();
        return response()->json(['success'=>true,'role'=>$role,'permissions'=>$permissions],200);
        
    }

    public function updaterole(Request $request,$id){
        $role=Role::find($id);
        // dd($role);
        $validator = FacadesValidator::make($request->all(), [
            'name' => [
                'sometimes',
                Rule::unique('roles')->ignore($role->id),
            ],
            'permissions'=>['sometimes'],
            'permissions.*'=>['exists:permissions,name'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $rolepermissions=$role->permissions;
        $role->revokePermissionTo($rolepermissions);
        $role->givePermissionTo($request->permissions);
        if($request->has('role')){
            $role->update(['name'=>$request->role]);
        }
        
        $role=$role->refresh();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        return response()->json(['success'=>true,'roles'=>$role],200);

    }
    
    public function store(RoleStoreRequest $request)
    {
        $data=$request->validated();
        $role=Role::create(['name'=>$request->role,'guard_name'=>'web'])->givePermissionTo($request->permissions);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        return response()->json(['success'=>true,'data'=>$role],200);
        
        //
    }

    public function destroy(Role $role){
        // $user = Auth::user();
        // if ($user->hasRole('admin')) {
            $permissions=$role->permissions;
            $role->revokePermissionTo($permissions);
            $role->delete();
            return response()->json(['data'=>'has deleted'],200);
        // }
        // return response()->json(['success'=>false,'message'=>'You do not have permission to destroy this role']);

        
    }
}
