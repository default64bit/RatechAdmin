<?php

namespace App\Http\Controllers\AdminPanel;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request){
        session()->put('counter',0);
        return redirect('admin/home');
    }

    public function home(Request $request){
        session()->put('counter',0);
        return view('admin.home');
    }


    public function profile(){
        return view('admin.profile');
    }

    public function edit_profile(Request $request){
        $admin = Auth::guard('admin')->user();

        $validated_request = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            'username' => 'required|max:255|unique:admins,id,'.$admin->id,
            'email' => 'required|max:255|email|unique:admins,id,'.$admin->id,
            'phone' => 'required|numeric|regex:/^(0)(9){1}[0-9]{9}+$/|unique:admins,phone,'.$admin->id,
        ]);
        if($validated_request->fails()){ return response()->json(['error'=>$validated_request->errors()],422); }

        $admin = Admin::findOrFail($admin->id);
        $admin->update([
            'name'=>$request->name,
            'family'=>$request->family,
            'username'=>$request->username,
            'email'=>$request->email,
            'phone'=>$request->phone,
        ]);
        if($request->hasFile('avatar_image')){
            $img = $request->file('avatar_image');
            $file_name = $admin->id.'.'.$img->getClientOriginalExtension();
            $img->move('img/admins', $file_name);
            $admin->update(['avatar_image'=>$file_name]);
        }
        return response(['success'=>true]);
    }

    public function change_password(Request $request){
        $admin = Auth::guard('admin')->user();

        $validated_request = Validator::make($request->all(),[
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8|different:old_password',
        ]);
        if($validated_request->fails()){ return response()->json(['error'=>$validated_request->errors()],422); }

        if(!Hash::check($request->old_password,$admin->password)){
            return response()->json(['error'=>['old_password'=>'رمزعبور قدیمی اشتباه است']],422);
        }

        $admin = Admin::findOrFail($admin->id);
        $admin->update([
            'password'=>bcrypt($request->new_password)
        ]);
        return response(['success'=>true]);
    }


}
