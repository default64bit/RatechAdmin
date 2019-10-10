<?php

namespace Default64bit\RatechAdmin\Controllers\AdminPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminPanel\AdminsRequest;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin.browse');
        $admins = Admin::where('id','!=',1)->latest()->paginate(20);
        return view('admin.admin_list.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin.add');
        $roles = Role::select('id','name')->where('name','!=','SuperAdmin')->get();
        return view('admin.admin_list.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminsRequest $request)
    {
        $this->authorize('admin.add');
        $admin = Admin::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        $roles = explode(',',$request->admin_roles);
        $admin->assignRole($roles);
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
        $this->authorize('admin.edit');
        $admin = Admin::findOrFail($id);
        $roles = Role::select('id','name')->where('name','!=','SuperAdmin')->get();
        $admin_roles = $admin->roles()->select('id','name')->get();
        return view('admin.admin_list.edit',['admin_details'=>$admin,'roles'=>$roles,'admin_roles'=>$admin_roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminsRequest $request, $id)
    {
        $this->authorize('admin.edit');

        $admin = Admin::findOrFail($id);
        $admin->update([
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
        ]);
        if($request->password !=""){
            $admin->update(['password'=>bcrypt($request->password)]);
        }

        $admin_roles = $admin->roles()->select('name')->get();
        foreach($admin_roles as $role){
            $admin->removeRole($role);
        }
        $roles = explode(',',$request->admin_roles);
        $admin->assignRole($roles);

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
        $this->authorize('admin.delete');
        $admin = Admin::findOrFail($id);
        $admin_roles = $admin->roles()->select('name')->get();
        foreach($admin_roles as $role){
            $admin->removeRole($role);
        }
        $admin->delete();
        return response(['success'=>true]);
    }
}
