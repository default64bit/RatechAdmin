<?php

namespace App\Http\Controllers\AdminPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class Panel_settingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('panel_settings.browse');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('panel_settings.add');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('panel_settings.add');
        //
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
        $this->authorize('panel_settings.edit');
        $setting_json = json_decode(Storage::get('settings.json'));
        return view('admin.panel_settings.edit', compact('setting_json'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('panel_settings.edit');

        $title = $request->title;
        if($request->hasFile('logo')){
            $logo = $request->file('logo');
            $file_name = 'logo.' . $logo->getClientOriginalExtension();
            $logo->move('img', $file_name);
        }else{
            $setting_json = json_decode(Storage::get('settings.json'));
            $file_name = $setting_json->logo;
        }
        $setting_json = json_encode([
            'title' => $title,
            'logo' => $file_name
        ]);
        $jsonData = Storage::put('panel_settings.json',);

        session()->flash('action_status', json_encode([
            'type' => 'info', 'icon' => "fad fa-pen",
            'title' => 'ویرایش تنظیمات', 'message' => 'تنظیمات با موفقیت ویرایش شد'
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
        $this->authorize('panel_settings.delete');
        //
    }
}
