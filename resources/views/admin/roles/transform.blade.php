@extends('templates.admin3')

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/select2/dist/css/select2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">تغییر دسترسی ادمین</h6>
    <div class="header-body">
        <div class="col-12 py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/roles')}}">لیست گروه بندی دسترسی ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تغییر دسترسی ادمین</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card bg-gradient-secondary shadow">
    <div class="card-body" name="transform_section">
        <h4 class="h4">به هر کدام از ادمین های زیر چه دسترسی اختصاص داده شود؟</h4>
        @foreach($admins as $admin)
        <div class="form-row mb-3">
            <div class="col-md-12">
                <label class="form-control-label" fa_name="{{$admin->name.' '.$admin->family}}">{{$admin->name.' '.$admin->family}}</label>
                <select class="form-control form-control-alternative" name="{{$admin->username}}" admin_id="{{$admin->id}}" tabindex="-1" aria-hidden="true">
                    <option value="" selected>یک گزینه را انتخاب کنید</option>
                    @foreach($roles as $role)
                        <option value="{{$role->name}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
    <div class="card-footer">
        <button class="btn btn-warning btn-air btn_add_confirm font-20" type="button">حذف دسترسی</button>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets3/vendor/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.navbar-search').remove();


    var form_data = new FormData();

    $('.btn_add_confirm').click(function(){
        var is_ok = true;
        var transform_list = {};
        $('.card-body[name="transform_section"] .form-row').each(function(index){
            var select = $(this).find('select');
            var username = select.attr('name');
            if(select.val() != ''){
                transform_list[select.attr('admin_id')] = select.val();
            }else{
                is_ok = false;
                notify_setting.type = 'danger';
                $.notify({
                    icon: 'fad fa-info', title: '',
                    message: `به ادمین "${username}" چه دسترسی داده شود`,
                },notify_setting);
            }
        });
        
        if(is_ok){
            form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
            form_data.append('transform_list',JSON.stringify(transform_list));
            load_screen(true);
            $.ajax({
                url: "{{url('admin/roles/'.$role_id.'/transform')}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
                complete: function(response){
                    load_screen(false);
                    response = JSON.parse(response.responseText);
                    if(response.success){
                        window.location.href = "{{url()->previous()}}";
                    }else{
                        //if(response.error){swal({title: '', text: response.error, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
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
                    //swal({title: data.responseText, type: "error", confirmButtonText: "خٌب"});
                }
            });
        }
    });

</script>
@endsection
