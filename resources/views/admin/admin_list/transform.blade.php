@extends('templates.admin3')

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/select2/dist/css/select2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">انتقال داده های ادمین</h6>
    <div class="header-body">
        <div class="col-12 py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/admins')}}">لیست ادمین ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">انتقال داده های ادمین</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card bg-gradient-secondary shadow">
    <div class="card-body" name="transform_section">
        @foreach($sections as $section)
        <div class="form-row mb-3">
            <div class="col-md-12">
                <label class="form-control-label" fa_name="{{$section['fa_name']}}"><b class="text-lg">{{$section['fa_name']}}</b> انتقال به</label>
                <select class="form-control form-control-alternative" name="{{$section['relation_name']}}" tabindex="-1" aria-hidden="true">
                    <option value="" selected>یک گزینه را انتخاب کنید</option>
                    @foreach($section['replacements'] as $replacement)
                        <option value="{{$replacement->id}}">{{$replacement->username}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
    <div class="card-footer">
        <button class="btn btn-warning btn-air btn_add_confirm font-20" type="button">انتقال دسترسی و حذف ادمین</button>
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
            var fa_name = $(this).find('label').attr('fa_name');
            if(select.val() != ''){
                transform_list[select.attr('name')] = select.val();
            }else{
                is_ok = false;
                notify_setting.type = 'danger';
                $.notify({
                    icon: 'fad fa-info', title: '',
                    message: `دیتا های ${fa_name} به چه کسی منتقل شود`, 
                },notify_setting);
            }
        });
        
        // admin_roles = admin_roles.toString();
        
        if(is_ok){
            form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
            form_data.append('transform_list',JSON.stringify(transform_list));
            load_screen(true);
            $.ajax({
                url: "{{url('admin/admins/'.$admin_id.'/transform')}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
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
