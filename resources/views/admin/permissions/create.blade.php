@extends('templates.admin3')

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">دسترسی جدید</h6>
    <div class="header-body">
        <div class="col-12 py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/permissions')}}">لیست دسترسی ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">دسترسی جدید</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-row mb-3">
            <div class="col-12">
                <label class="form-control-label">عنوان</label>
                <input type="text" class="form-control" name="label" placeholder="">
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col-12">
                <label class="form-control-label">نام</label>
                <input type="text" class="form-control" name="name" placeholder="">
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
<script>
    $('.navbar-search').remove();

    var form_data = new FormData();

    $('.btn_add_confirm').click(function(){
        var label = $('.card-body input[name="label"]').val();
        var name = $('.card-body input[name="name"]').val();
        
        if(label !="" && name !=""){
            form_data.append('_token',$('meta[name=csrf-token]').attr('content'));
            form_data.append('label',label);
            form_data.append('name',name);
            load_screen(true);
            $.ajax({
                url: "{{url('admin/permissions')}}", type: "post", data: form_data, dataType: "text", cache: false, contentType: false, processData: false,
                complete: function(response){
                    load_screen(false);
                    response = JSON.parse(response.responseText);
                    if(response.success){
                        window.location.href = "{{url()->previous()}}";
                    }else{
                        if(response.error.name){Swal.fire({title: '', text: response.error.name, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                        if(response.error.label){Swal.fire({title: '', text: response.error.label, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});}
                    }
                },
                success: function(data){},
                error: function(data){ Swal.fire({ title: data.responseText, type: "error", confirmButtonText: "خٌب" }); }
            });
        }
    });

</script>
@endsection
