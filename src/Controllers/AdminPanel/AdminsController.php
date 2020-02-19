<?php

namespace App\Http\Controllers\AdminPanel;

use App\Helpers\ModelHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminPanel\AdminsRequest;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('admin.read');
        $admins = Admin::with('roles')->where('id','!=',1)->latest();
        if($request->has('search')){
            $search = $request->search;
            $admins = ModelHelper::search($admins,Admin::SEARCHABLE,$search);
        }
        if($request->has('role_filter') && $request->role_filter != ''){
            $role_filter = $request->role_filter;
            $admins = $admins->whereHas('roles',function(Builder $query) use ($role_filter){
                $query->where('name',$role_filter);
            });
        }
        if($request->has('status_filter') && $request->status_filter != ''){
            $status_filter = $request->status_filter;
            $admins = $admins->where('disable',$status_filter);
        }
        $admins = $admins->paginate(20);

        $relations = Admin::RELATIONS_FOR_CHECK;
        foreach($admins as &$admin){
            foreach($relations as $relation){
                if(count($admin[$relation['relation_name']])){
                    $admin['has_relation'] = 1;
                }
            }
        }

        $roles = DB::table('roles')->where('name','!=','SuperAdmin')->where('guard_name','admin')->get();

        $compact = [
            'admins' => $admins,
            'roles' => $roles,
        ];
        if(isset($role_filter)){ $compact['role_filter'] = $role_filter; }
        if(isset($status_filter)){ $compact['status_filter'] = $status_filter; }
        if(isset($search)){ $compact['search'] = $search; }
        return view('admin.admin_list.index',$compact);
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
            'family'=>$request->family,
            'username'=>$request->username,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>bcrypt($request->password),
        ]);
        // $roles = explode(',',$request->admin_roles);
        $role = $request->admin_role;
        $admin->assignRole($role);

        session()->flash('action_status', json_encode([
            'type' => 'success', 'icon' => "fad fa-plus", 'title' => '',
            'message' =>  $admin->username.' با موفقیت ایجاد شد'
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
        $this->authorize('admin.edit');
        $admin = Admin::findOrFail($id);
        $roles = Role::select('id','name')->where('name','!=','SuperAdmin')->get();
        $admin_role = $admin->roles()->select('id','name')->first();
        $admin_roles = $admin->roles()->select('id','name')->get();
        return view('admin.admin_list.edit',['admin_details'=>$admin,'roles'=>$roles,'admin_roles'=>$admin_roles,'admin_role'=>$admin_role]);
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
            'family'=>$request->family,
            'username'=>$request->username,
            'email'=>$request->email,
            'phone'=>$request->phone,
        ]);
        if($request->password !=""){
            $admin->update(['password'=>bcrypt($request->password)]);
        }

        $admin_roles = $admin->roles()->select('name')->get();
        foreach($admin_roles as $role){
            $admin->removeRole($role->name);
        }
        // $roles = explode(',',$request->admin_roles);
        $role = $request->admin_role;
        $admin->assignRole($role);

        session()->flash('action_status', json_encode([
            'type' => 'info', 'icon' => "fad fa-pen", 'title' => '',
            'message' => $admin->username.' با موفقیت ویرایش شد'
        ]));

        return response(['success'=>true]);
    }

    /**
     * Show the form for transforming the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transform_page($id)
    {
        $this->authorize('admin.transform');
        $admin = Admin::findOrFail($id);
        $admin_id = $id;
        $sections = [];
        foreach(Admin::RELATIONS_FOR_CHECK as $relation){
            try{
                array_push($sections,[
                    'relation_name' => $relation['relation_name'],
                    'fa_name' => $relation['fa_name'],
                    'replacements' => Admin::where('id','!=',$id)->where('name','!=','SuperAdmin')->permission($relation['permission_name'].'.read')->get(),
                ]);
            }catch(Exception $e){}
        }
        return view('admin.admin_list.transform',compact('sections','admin_id'));
    }

    /**
     * Transform the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transform(Request $request, $id)
    {
        $this->authorize('admin.transform');

        $transforms = json_decode($request->transform_list);
        $relations = array_keys(json_decode($request->transform_list,true));
        $admin = Admin::with($relations)->findOrFail($id);
        
        foreach($transforms as $section => $transform){
            foreach($admin[$section] as $section_item){
                $section_item[Admin::RELATIONS_FOR_CHECK[$section]['foreign_key']] = $transform;
                $section_item->save();
            }
        }

        $admin->delete();

        session()->flash('action_status', json_encode([
            'type' => 'danger', 'icon' => "fad fa-pen", 'title' => '',
            'message' => $admin->username.' با موفقیت حذف شد'
        ]));

        return response()->json(['success'=>true]);
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $this->authorize('admin.disable');
        $admin = Admin::findOrFail($id);
        $admin->update(['disable'=>$admin->disable?0:1]);
        return response(['success'=>true,'state'=>$admin->disable,'model'=>$admin]);
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
