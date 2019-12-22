<?php

namespace App\Http\Controllers\AdminPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\PermissionsRequest;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('permission.read');
        $permissions = Permission::where('guard_name','admin')->latest()->paginate(20);
        return view('admin.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('permission.add');
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionsRequest $request)
    {
        $this->authorize('permission.add');
        $permission = Permission::create([
            'name' => $request->name,
            'label' => $request->label,
        ]);

        session()->flash('action_status', json_encode([
            'type' => 'success', 'icon' => "fad fa-plus",
            'title' => 'دسترسی ادمین', 'message' => 'ادمین جدید با موفقیت دسترسی شد'
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
        $this->authorize('permission.edit');
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionsRequest $request, $id)
    {
        $this->authorize('permission.edit');
        $permission = Permission::find($id)->update([
            'name' => $request->name,
            'label' => $request->label,
        ]);

        session()->flash('action_status', json_encode([
            'type' => 'info', 'icon' => "fad fa-pen",
            'title' => 'ویرایش دسترسی', 'message' => 'دسترسی با موفقیت ویرایش شد'
        ]));

        return response(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('permission.delete');
        $permission = Permission::findOrFail($id);
        $roles = Role::join('role_has_permissions as rhp','rhp.role_id','roles.id')->where('rhp.permission_id',$id)->get();
        foreach($roles as $role){
            $role->revokePermissionTo($permission->name);
        }
        $permission->delete();
        return response(['success'=>true]);
    }
}
