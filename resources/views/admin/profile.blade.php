@extends('templates.admin3')

@section('title')
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header d-flex align-items-center" style="min-height:300px;">
    <span class="mask bg-gradient-purple opacity-8 vw-100" style="margin-left:-30px;"></span>
    <div class="container-fluid d-flex align-items-center"></div>
</div>
<div class="row p-4">
    <div class="col-xl-8 col-lg-10 col-md-12 mt--9">
        <div class="card bg-gradient-secondary shadow">
            <div class="card-body">
                <div class="form-row mb-3 mt--7">
                    <div class="col-12">
                        <div class="card img_upload p-2">
                            <img src="{{$admin->avatar_image!=''?asset('img/admins/'.$admin->avatar_image):asset('assets3/img/faces/avatar6.png')}}" alt="" >
                            <button class="btn" type="button">انتخاب عکس</button>
                            <input type="file" class="file_upload" name="avatar_image">
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">نام</label>
                        <input type="text" class="form-control form-control-alternative" name="name" value="{{$admin->name}}">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-6">
                        <label class="form-control-label">نام کاربری</label>
                        <input type="text" class="form-control form-control-alternative" name="username" value="{{$admin->username}}">
                    </div>
                    <div class="col-6">
                        <label class="form-control-label">ایمیل</label>
                        <input type="text" class="form-control form-control-alternative" name="email" value="{{$admin->email}}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-info btn-air btn_edit_confirm font-20" type="button">ویرایش <i class="fas fa-pen"></i></button>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-10 col-md-12 mt-xl--9 mt-xs-0">
        <div class="card bg-gradient-secondary shadow">
            <div class="card-body">
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">رمزعبور قدیمی</label>
                        <input type="text" class="form-control form-control-alternative" name="old_password">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">رمزعبور جدید</label>
                        <input type="text" class="form-control form-control-alternative" name="new_password">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning btn-air btn_change_pass_confirm font-20" type="button">تغییر رمزعبور <i class="fad fa-lock-alt"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script>
    $(document).ready(function(){
        var image = "<?=asset('img/admins/'.$admin->avatar_image)?>";
        if(image[image.length-1] != 's'){
            $('input[name="avatar_image"]').closest('.img_upload').children('img').attr('src',image);
        }
    });

    var form_data = new FormData();
    $('.img_upload .file_upload').change(function(event){
        form_data.append($(this).attr('name'),event.target.files[0]);
    });
    $('.img_upload button').click(function(e){
        e.preventDefault(); $(this).parent().children('input[type="file"]').click();
    });

    $('.btn_edit_confirm').click(function(){
        var name = $('.card-body input[name="name"]').val();
        var username = $('.card-body input[name="username"]').val();
        var email = $('.card-body input[name="email"]').val();
        
        if(name !="" && username !="" && email !=""){
            form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
            form_data.append('name',name);
            form_data.append('username',username);
            form_data.append('email',email);
            load_screen(true);
            $.ajax({
                url: "{{url('admin/edit_profile')}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
                complete: function(response){
                    load_screen(false);
                    response = JSON.parse(response.responseText);
                    if(response.success){
                        Swal.fire({title: '', text: 'پروفایل ویرایش شد', type: "success", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});
                    }else{
                        if(response.error.name){Swal.fire({title: '', text: response.error.name, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                        if(response.error.username){Swal.fire({title: '', text: response.error.username, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                        if(response.error.email){Swal.fire({title: '', text: response.error.email, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                    }
                },
                success: function(response){},
                error: function(response){ Swal.fire({ title: response.responseText, type: "error", confirmButtonText: "خٌب" }); }
            });
        }
    });


    $('.btn_change_pass_confirm').click(function(){
        var old_password = $('.card-body input[name="old_password"]').val();
        var new_password = $('.card-body input[name="new_password"]').val();
        
        if(old_password !="" && new_password !=""){
            var change_pass_form_data = new FormData();
            change_pass_form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
            change_pass_form_data.append('old_password',old_password);
            change_pass_form_data.append('new_password',new_password);
            load_screen(true);
            $.ajax({
                url: "{{url('admin/change_password')}}", type: "post", data: change_pass_form_data, dataType: "text", cache: false, contentType: false, processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                complete: function(response){
                    load_screen(false);
                    response = JSON.parse(response.responseText);
                    if(response.success){
                        Swal.fire({title: '', text: 'رمزعبور تغییر کرد', type: "success", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});
                    }else{
                        if(response.error.old_password){Swal.fire({title: '', text: response.error.old_password, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                        if(response.error.new_password){Swal.fire({title: '', text: response.error.new_password, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                    }
                },
                success: function(response){},
                error: function(response){ Swal.fire({ title: response.responseText, type: "error", confirmButtonText: "خٌب" }); }
            });
        }
    });

</script>
@endsection
