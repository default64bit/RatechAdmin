<?php

namespace App\Http\Controllers\AdminPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\AdminPanel\RolesRequest;
use App\Models\Admin;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('role.read');
        $roles = Role::where('name','!=','SuperAdmin')->where('guard_name','admin')->latest();
        if($request->has('search')){
            $search = $request->search;
            $roles = ModelHelper::search($roles,['name','label'],$search);
        }
        if($request->has('status_filter') && $request->status_filter != ''){
            $status_filter = $request->status_filter;
            $roles = $roles->where('disable',$status_filter);
        }
        $roles = $roles->paginate(20);

        foreach($roles as &$role){
            if(Admin::role($role->name)->count()){
                $role['has_relation'] = 1;
            }
        }

        return view('admin.roles.index',compact('roles','status_filter','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('role.add');
        $permissions = Permission::select('id','name','label')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesRequest $request)
    {
        $this->authorize('role.add');

        $role = Role::create([
            'name'=>$request->name,
            'label'=>$request->name,
        ]);
        $permissions = explode(',',$request->permissions);
        foreach($permissions as $permission_id){
            $permission = Permission::find($permission_id);
            if($permission){ $role->givePermissionTo($permission); }
        }

        session()->flash('action_status', json_encode([
            'type' => 'success', 'icon' => "fad fa-plus",
            'title' => 'دسترسی نقش', 'message' => 'نقش جدید با موفقیت دسترسی شد'
        ]));

        return response(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('role.edit');
        $role = Role::findOrFail($id);
        $permissions = Permission::select('id','name','label')->get();
        $role_permissions = $role->permissions()->select('id')->get();
        return view('admin.roles.edit',['role'=>$role,'permissions'=>$permissions,'role_permissions'=>$role_permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesRequest $request, $id)
    {
        $this->authorize('role.edit');
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'label' => $request->name,
        ]);
        $role_permissions = $role->permissions()->get();
        foreach($role_permissions as $permission){
            $role->revokePermissionTo($permission->name);
        }
        $permissions = explode(',',$request->permissions);
        foreach($permissions as $permission_id){
            $permission = Permission::find($permission_id);
            if($permission){ $role->givePermissionTo($permission); }
        }

        session()->flash('action_status', json_encode([
            'type' => 'info', 'icon' => "fad fa-pen",
            'title' => 'ویرایش نقش', 'message' => 'نقش با موفقیت ویرایش شد'
        ]));
        
        return response(['success'=>true]);
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $this->authorize('role.disable');
        $role = Role::findOrFail($id);
        $role->update(['disable'=>$role->disable?0:1]);
        return response(['success'=>true,'state'=>$role->disable,'model'=>$role]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('role.delete');

        $role = Role::findOrFail($id);
        $admins = Admin::role($role->name)->get();
        foreach($admins as $admin){
            $admin->removeRole($role->name);
        }
        $role_permissions = $role->permissions()->get();
        foreach($role_permissions as $permission){
            $role->revokePermissionTo($permission->name);
        }
        $role->delete();

        return response(['success'=>true]);
    }
}
