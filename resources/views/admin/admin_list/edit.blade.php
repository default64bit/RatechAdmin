@extends('templates.admin3')

@section('title')
ویرایش ادمین
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/select2/dist/css/select2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">ویرایش ادمین</h6>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/admins')}}">لیست ادمین ها</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ویرایش ادمین</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-content fade-in-up">
    <div class="card bg-gradient-secondary shadow">
        <div class="card-body">
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="form-control-label">نام <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                    <input type="text" class="form-control form-control-alternative" name="name" placeholder="" value="{{$admin_details->name}}">
                </div>
                <div class="col-md-6">
                    <label class="form-control-label">نام خانوادگی <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                    <input type="text" class="form-control form-control-alternative" name="family" placeholder="" value="{{$admin_details->family}}">
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="form-control-label">موبایل <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                    <input type="text" class="form-control form-control-alternative" name="phone" placeholder="09120000000" value="{{$admin_details->phone}}">
                </div>
                <div class="col-md-6">
                    <label class="form-control-label">ایمیل <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                    <input type="text" class="form-control form-control-alternative" name="email" placeholder="example@example.com" value="{{$admin_details->email}}">
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label class="form-control-label">نام کاربری <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                    <input type="text" class="form-control form-control-alternative" name="username" placeholder="" value="{{$admin_details->username}}">
                </div>
                <div class="col-md-6">
                    <label class="form-control-label">سطح دسترسی <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                    <select class="form-control form-control-alternative" name="admin_role" tabindex="-1" aria-hidden="true">
                        <option value="">یک گزینه را انتخاب کنید</option>
                        @foreach($roles as $role)
                            <option value="{{$role->name}}" {{$role->id==$admin_role->id ? 'selected' : ''}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-6">
                    <label class="form-control-label">رمزعبور</label>
                    <input type="password" class="form-control form-control-alternative" name="password" placeholder="حداقل 8 کاراکتر">
                    <span class="password_visiable_btn"><i class="fad fa-eye"></i></span>
                </div>
                <div class="col-6">
                    <label class="form-control-label">تکرار رمزعبور</label>
                    <input type="password" class="form-control form-control-alternative" name="password_confirmation" placeholder="حداقل 8 کاراکتر">
                    <span class="password_visiable_btn"><i class="fad fa-eye"></i></span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-info btn-air btn_edit_confirm font-20" type="button">ویرایش <i class="fas fa-pen"></i></button>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets3/vendor/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.navbar-search').remove();
    
    // $('select[name="admin_roles"]').select2({dir:'rtl'});

    $('document').ready(function(){
        // var admin_roles = <?=json_encode($admin_roles)?>;
        // var selection = [];
        // admin_roles.forEach(element=>{ selection.push(element.name); });
        // $('select[name="admin_roles"]').val(selection).trigger("change");
    });

    var form_data = new FormData();

    $('.btn_edit_confirm').click(function(){
        var name = $('.card-body input[name="name"]').val();
        var family = $('.card-body input[name="family"]').val();
        var username = $('.card-body input[name="username"]').val();
        var email = $('.card-body input[name="email"]').val();
        var phone = $('.card-body input[name="phone"]').val();
        var password = $('.card-body input[name="password"]').val();
        var password_confirmation = $('.card-body input[name="password_confirmation"]').val();
        var admin_role = $('select[name="admin_role"]').val();
        // admin_roles = admin_roles.toString();
        
        form_data.append('_method','PUT');
        form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
        form_data.append('id',{{$admin_details->id}});
        form_data.append('name',name);
        form_data.append('family',family);
        form_data.append('username',convertPersianNumbers(username));
        form_data.append('email',email);
        form_data.append('phone',convertPersianNumbers(phone));
        form_data.append('password',convertPersianNumbers(password));
        form_data.append('password_confirmation',convertPersianNumbers(password_confirmation));
        form_data.append('admin_role',admin_role);
        load_screen(true);
        $.ajax({
            url: "{{url('admin/admins/'.$admin_details->id)}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
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

</script>
@endsection
