@extends('templates.admin3')

@section('title')
ویرایش گروه بندی دسترسی
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">ویرایش گروه بندی دسترسی</h6>
    <div class="header-body">
        <div class="col-12 py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/roles')}}">لیست گروه بندی دسترسی ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ویرایش گروه بندی دسترسی</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="col-12">
                <label class="form-control-label">عنوان</label>
                <input type="text" class="form-control" name="name" placeholder="" value="{{$role->name}}">
            </div>
        </div>
        <hr>
        <?php
            $models_array = [];
            foreach($permissions as $permission){
                $model = explode('.',$permission['name'])[0];
                if(!isset($models_array[$model])){
                    $models_array[$model] = [];
                    array_push($models_array[$model],[$permission->id,$permission['name'],$permission['label']]);
                }else{ array_push($models_array[$model],[$permission->id,$permission['name'],$permission['label']]); }
            }
        ?>
        <div class="col-12">
            <ul class="navbar-nav">
                @foreach($models_array as $name => $permission)
                <li class="nav-item" name="nav_group">
                    <div class="d-flex align-items-center my-1">
                        <div class="custom-control custom-checkbox" name="check_all" id="check-all-{{$permission[0][0]}}">
                            <input type="checkbox" class="custom-control-input" name="check_all" id="{{$permission[0][0]}}">
                            <label class="custom-control-label" for="{{$permission[0][0]}}"></label>
                        </div>
                        <a class="nav-link" href="#navbar-{{$permission[0][0]}}" data-toggle="collapse" role="button" aria-expanded="false">
                            <span class="nav-link-text">{{str_replace('جستجو ','',$permission[0][2])}}</span>
                        </a>
                        <i class="fad fa-chevron-down mt-2 mr-2"></i>
                    </div>
                    <div class="collapse bg-secondary" id="navbar-{{$permission[0][0]}}">
                        <ul class="nav nav-sm flex-column px-4">
                            @foreach($permission as $item)
                            <li class="nav-item">
                                <span class="nav-link">
                                    <div class="custom-control custom-checkbox" name="permission_item">
                                        <input type="checkbox" class="custom-control-input" permission_id="{{$item[0]}}" name="{{$item[1]}}" id="{{$item[0]}}_{{$item[1]}}">
                                        <label class="custom-control-label" for="{{$item[0]}}_{{$item[1]}}"> {{$item[2]}} </label>
                                    </div>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-info btn-air btn_edit_confirm font-20" type="button">ویرایش <i class="fas fa-pen"></i></button>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script>
    $('.navbar-search').remove();

    $('document').ready(function(){
        var role_permissions = <?=json_encode($role_permissions)?>;
        role_permissions.forEach(element=>{
            $('input[type="checkbox"][permission_id="'+element.pivot.permission_id+'"]').prop("checked",true);
        });
        
    });

    var form_data = new FormData();

    $('.btn_edit_confirm').click(function(){
        var name = $('.card-body input[name="name"]').val();
        var permissions = [];
        $('div[name="permission_item"]').each(function(index){
            var checkbox = $(this).find('input[type="checkbox"]');
            if(checkbox.prop("checked")){
                permissions.push(checkbox.attr('permission_id'));
            }
        });
        permissions = JSON.stringify(permissions);
        
        form_data.append('_method','PUT');
        form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
        form_data.append('id',{{$role->id}});
        form_data.append('permissions',permissions);
        form_data.append('name',name);
        load_screen(true);
        $.ajax({
            url: "{{url('admin/roles/'.$role->id)}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            complete: function(response){
                load_screen(false);
                response = JSON.parse(response.responseText);
                if(response.success){
                    window.location.href = "{{url()->previous()}}";
                }else{
                    //if(response.error){Swal.fire({title: '', text: response.error, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                    notify_setting.type = 'danger';
                    $.notify({
                        icon: 'fad fa-info',
                        title: '',
                        message: response.error, 
                    },notify_setting);
                }
            },
            success: function(response){},
            error: function(response){
                //Swal.fire({ title: response.responseText, type: "error", confirmButtonText: "خٌب" });
            }
        });
    });

    $('.custom-checkbox[name="check_all"]').click(function(){
        var checkbox = $(this).find('input[type="checkbox"]');
        if(checkbox.prop("checked")){
            $(this).closest('.nav-item').find('div[name="permission_item"] input').prop("checked",true);
        }else{
            $(this).closest('.nav-item').find('div[name="permission_item"] input').prop("checked",false);
        }
    });
    $('.custom-checkbox[name="permission_item"] input[type="checkbox"]').change(function(){
        //var checkbox = $(this).find('input[type="checkbox"]');
        var checkbox = $(this);
        if(checkbox.prop("checked")){
            var all_true = true;
            $(this).closest('ul').find('li input[type="checkbox"]').each(function(index){
                if(!$(this).prop("checked")){
                    all_true = false;
                }
            });
            if(all_true){
                $(this).closest('li[name="nav_group"]').find('.custom-checkbox[name="check_all"] input').prop("checked",true);    
            }
        }else{
            $(this).closest('li[name="nav_group"]').find('.custom-checkbox[name="check_all"] input').prop("checked",false);
        }
    });

</script>
@endsection
