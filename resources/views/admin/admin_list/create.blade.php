@extends('templates.admin3')

@section('title')
ادمین جدید
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/select2/dist/css/select2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">ادمین جدید</h6>
    <div class="header-body">
        <div class="col-12 py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/admins')}}">لیست ادمین ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ادمین جدید</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card bg-gradient-secondary shadow">
    <div class="card-body">
        <div class="form-row mb-3">
            <div class="col-md-6">
                <label class="form-control-label">نام <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <input type="text" class="form-control form-control-alternative" name="name" placeholder="">
            </div>
            <div class="col-md-6">
                <label class="form-control-label">نام خانوادگی <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <input type="text" class="form-control form-control-alternative" name="family" placeholder="">
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col-md-6">
                <label class="form-control-label">موبایل <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <input type="text" class="form-control form-control-alternative" name="phone" placeholder="09120000000">
            </div>
            <div class="col-md-6">
                <label class="form-control-label">ایمیل <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <input type="text" class="form-control form-control-alternative" name="email" placeholder="example@example.com">
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col-md-6">
                <label class="form-control-label">نام کاربری <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <input type="text" class="form-control form-control-alternative" name="username" placeholder="">
            </div>
            <div class="col-md-6">
                <label class="form-control-label">سطح دسترسی <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <select class="form-control form-control-alternative" name="admin_role" tabindex="-1" aria-hidden="true">
                    <option value="" selected>یک گزینه را انتخاب کنید</option>
                    @foreach($roles as $role)
                        <option value="{{$role->name}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col-6">
                <label class="form-control-label">رمزعبور <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <input type="password" class="form-control form-control-alternative" name="password" placeholder="حد اقل ۸ کاراکتر باید باشد">
                <span class="password_visiable_btn"><i class="fad fa-eye"></i></span>
            </div>
            <div class="col-6">
                <label class="form-control-label">تکرار رمزعبور <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                <input type="password" class="form-control form-control-alternative" name="password_confirmation" placeholder="حد اقل ۸ کاراکتر باید باشد">
                <span class="password_visiable_btn"><i class="fad fa-eye"></i></span>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success btn-air btn_add_confirm font-20" type="button">افزودن <i class="fas fa-plus"></i></button>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets3/vendor/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.navbar-search').remove();

    // $('select[name="admin_roles"]').select2({dir:'rtl'});

    var form_data = new FormData();

    $('.btn_add_confirm').click(function(){
        var name = $('.card-body input[name="name"]').val();
        var family = $('.card-body input[name="family"]').val();
        var username = $('.card-body input[name="username"]').val();
        var email = $('.card-body input[name="email"]').val();
        var phone = $('.card-body input[name="phone"]').val();
        var password = $('.card-body input[name="password"]').val();
        var password_confirmation = $('.card-body input[name="password_confirmation"]').val();
        var admin_role = $('select[name="admin_role"]').val();
        // admin_roles = admin_roles.toString();
        
        form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
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
            url: "{{url('admin/admins')}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
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
            success: function(data){},
            error: function(data){
                if(data.status == 403){
                    notify_setting.type = 'danger';
                    $.notify({
                        icon: 'fad fa-info', title: '', message: 'شما به این قسمت دسترسی ندارید',
                    },notify_setting);
                }
            }
        });
    });

</script>
@endsection
