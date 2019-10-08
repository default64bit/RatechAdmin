@extends('templates.admin3')

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">نقش جدید</h6>
    <div class="header-body">
        <div class="col-12 py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/roles')}}">لیست نقش ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">نقش جدید</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="col-12">
                <label class="form-control-label">نام</label>
                <input type="text" class="form-control" name="name" placeholder="">
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
            @foreach($models_array as $name => $permission)
            <h4 class="badge badge-dark text-white">{{$name}}</h4>
            <div class="form-row card p-2 d-flex flex-row justify-content-between">
                @foreach($permission as $item)
                <div class="custom-control custom-checkbox" name="permission_item">
                    <input type="checkbox" class="custom-control-input" permission_id="{{$item[0]}}" name="{{$item[1]}}" id="{{$item[0]}}_{{$item[1]}}">
                    <label class="custom-control-label" for="{{$item[0]}}_{{$item[1]}}"> {{$item[2]}} </label>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success btn-air btn_add_confirm font-20" type="button">افزودن <i class="fas fa-plus"></i></button>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script>
    $('.navbar-search').remove();

    var form_data = new FormData();

    $('.btn_add_confirm').click(function(){
        var name = $('.card-body input[name="name"]').val();
        var permissions = [];
        $('div[name="permission_item"]').each(function(index){
            var checkbox = $(this).find('input[type="checkbox"]');
            if(checkbox.prop("checked")){
                permissions.push(checkbox.attr('permission_id'));
            }
        });
        permissions = permissions.toString();
        
        if(name !="" && permissions !=""){
            form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
            form_data.append('name',name);
            form_data.append('permissions',permissions);
            load_screen(true);
            $.ajax({
                url: "{{url('admin/roles')}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
                complete: function(response){
                    load_screen(false);
                    response = JSON.parse(response.responseText);
                    if(response.success){
                        window.location.href = "{{url()->previous()}}";
                    }else{
                        if(response.error.name){Swal.fire({title: '', text: response.error.name, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                        if(response.error.permissions){Swal.fire({title: '', text: response.error.permissions, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                    }
                },
                success: function(data){},
                error: function(data){ Swal.fire({ title: data.responseText, type: "error", confirmButtonText: "خٌب" }); }
            });
        }
    });

</script>
@endsection
