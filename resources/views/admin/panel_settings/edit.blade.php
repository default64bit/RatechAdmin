@extends('templates.admin3')

@section('title')
    تنظیمات پنل
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/select2/dist/css/select2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3"> تنظیمات پنل </h6>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">ویرایش تنظیمات پنل</li>
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
                <div class="col-md-12">
                    <div class="img_upload">
                        <img src="{{asset('img/'.$setting_json->logo)}}" alt="">
                        <button class="btn btn-default" type="button">انتخاب لوگو</button>
                        <input type="file" class="file_upload" name="logo">
                    </div>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-12">
                    <label class="form-control-label">عنوان پنل</label>
                    <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i>
                    <input type="text" class="form-control form-control-alternative" name="title" placeholder=""
                            value="{{old('title',$setting_json->title)}}">
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
<script src="{{asset('assets3/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>

<script>
    $('.navbar-search').remove();

    var form_data = new FormData();
    $('.img_upload .file_upload').change(function (event) {
        form_data.append($(this).attr('name'), event.target.files[0]);
    });
    $('.img_upload button').click(function (e) {
        e.preventDefault(); $(this).parent().children('input[type="file"]').click();
    });

    $('.btn_edit_confirm').click(function(){
        var title = $('.card-body input[name="title"]').val();
        if(title != ''){
            form_data.append('_method', 'post');
            form_data.append('_token', $('meta[name=csrf-token]').attr('content'));
            form_data.append('title', title);

            load_screen(true);
            $.ajax({
                url: "{{url('admin/settings')}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                complete: function(response){
                    load_screen(false);
                    response = JSON.parse(response.responseText);
                    if(response.success){
                        Swal.fire({title: '', text: 'تنظیمات ویرایش شد', type: "success", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});
                    }else{
                        if(response.error){
                            Swal.fire({title: '', text: response.error, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});
                        }
                    }
                },
                success: function(response){},
                error: function(response){ Swal.fire({ title: data.responseText, type: "error", confirmButtonText: "خٌب" }); }
            });
        }
    });

</script>
@endsection
