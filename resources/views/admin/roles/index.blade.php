@extends('templates.admin3')

@section('title')
لیست گروه بندی دسترسی ها
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/animate.css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">

<link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">لیست گروه بندی دسترسی ها</h6>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">لیست گروه بندی دسترسی ها</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col">
    <div class="card">
        <div class="card-body py-0 px-3">
            <div class="col-12 p-0 py-3 d-flex align-items-center justify-content-between">
                @can('role.add')
                <a class="btn_add btn btn-success" href="{{url('admin/roles/create')}}"><i class="far fa-plus"></i> گروه بندی دسترسی جدید </a>
                @endcan
                <div class="d-flex">
                    <select class="form-control form-control-alternative w-auto" name="status_filter">
                        <option value="" selected>همه وضعیت ها</option>
                        <option value="1" {{isset($status_filter)&&$status_filter==1 ? 'selected' : ''}}>غیرفعال</option>
                        <option value="0" {{isset($status_filter)&&$status_filter==0 ? 'selected' : ''}}>فعال</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <div class="table-responsive pb-4">
                    <table class="table table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>ردیف</th>
                                <th>سطح دسترسی</th>
                                <th>زمان ثبت</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = ($roles->currentpage()-1) * $roles->perpage(); $i++; ?>
                            @foreach($roles as $role)
                            <tr row-id="{{$role->id}}" has_relation="{{$role->has_relation}}" name="{{$role->name}}">
                                <td>{{$i++}}</td>
                                <td>{{$role->name}}</td>
                                <td dir="ltr">{{Morilog\Jalali\Jalalian::forge($role->created_at)->format('%Y/%m/%d H:i')}}</td>
                                <td>
                                    @if($role->disable == 0)
                                        <span class="badge badge-pill badge-success" ban>فعال</span>
                                    @else
                                        <span class="badge badge-pill badge-danger" ban>غیرفعال</span>
                                    @endif
                                </td>
                                <td>
                                    @can('role.edit') <a class="table-action text-info" data-toggle="tooltip" data-original-title="ویرایش" href="{{url('admin/roles/'.$role->id.'/edit')}}"><i class="far fa-edit"></i></a> @endcan
                                    @can('role.delete') <a class="table-action btn_delete text-danger" data-toggle="tooltip" data-original-title="حذف" row-id="{{$role->id}}"><i class="far fa-trash-alt"></i></a> @endcan
                                    @can('role.disable')
                                        <a class="table-action btn_disable text-warning" data-toggle="tooltip" data-original-title="فعال سازی و غیر فعال سازی" row-id="{{$role->id}}" name="{{$role->name}}" status="{{$role->disable}}">
                                            @if($role->disable == 0) <i class="far fa-ban"></i> @else <i class="far fa-check"></i> @endif
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <?php
                    $append_array = [];
                    if(isset($search) && !empty($search)){ $append_array['search'] = $search; }
                    if(isset($status_filter)){ $append_array['status_filter'] = $status_filter; }
                ?>
                {{$roles->appends($append_array)->links()}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets3/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<script src="{{asset('assets3/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets3/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets3/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets3/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets3/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets3/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets3/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets3/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>

@if(session()->has('action_status'))
<?php $status = json_decode(session()->get('action_status'))?>
<script>
    $(document).ready(function () {
        notify_setting.type = '<?=$status->type?>';
        $.notify({
            icon: '<?=$status->icon?>',
            title: '<?=$status->title?>',
            message: '<?=$status->message?>'
        }, notify_setting);
    });
</script>
@endif

<script>
    var table = $('#datatable').DataTable({
        paging: false, pageLength: 200,
        fixedHeader: true, responsive: true,
        "sDom": 'rtip',
        columnDefs: [{
            targets: 'no-sort', orderable: false
        }],
        "order": [[0, "desc"]],
        "language": {
            "infoEmpty": "",
            "info": "نمایش _START_ تا _END_ ردیف (از _TOTAL_ رکورد)",
            "emptyTable": "اطلاعاتی برای نمایش وجود ندارد"
        }
    });
    $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
    });
    $('.navbar-search input').attr('placeholder','جستجو گروه بندی دسترسی ها');
    @cannot('role.browse') $('.navbar-search').remove(); @endcannot

    $('.btn_delete').click(function(){
        var record_id = $(this).attr('row-id');
        var elm = $('.dataTable tr[row-id="'+record_id+'"]');
        var name = elm.attr('name');
        var has_relation = elm.attr('has_relation');

        var question = has_relation==1 ? `پیش از حذف دسترسی "${name}" لازم است تا دسترسی دیگری به ادمین های دارای این دسترسی اختصاص دهید` : `آیا "${name}" حذف شود؟`;
        var confirmButtonText = has_relation==1 ? 'اختصاص دسترسی' : 'بله';
        var cancelButtonText = has_relation==1 ? 'لغو' : 'خیر';
        Swal.fire({
            title: "", text: question, type: "question", showCancelButton: true, buttonsStyling: false,
            confirmButtonClass: "btn btn-danger m-1", confirmButtonText: confirmButtonText,
            cancelButtonClass: "btn btn-secondary m-1", cancelButtonText: cancelButtonText
        }).then((result)=>{
            if(result.value){
                if(has_relation==1){
                    window.location.href = "{{url('admin/roles')}}/"+record_id+"/transform";
                }else{
                    load_screen(true);
                    $.ajax({
                        url: "{{url('admin/roles')}}/"+record_id, type: "delete", cache: false, contentType: false, processData: false,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        complete: function(response){
                            load_screen(false);
                            response = JSON.parse(response.responseText);
                            if(response.success){
                                table.row(elm).remove().draw();
                                notify_setting.type = 'success';
                                $.notify({
                                    icon: 'fad fa-trash', title: '',
                                    message: `${name} حذف شد`,
                                },notify_setting);
                            }else{
                                notify_setting.type = 'danger';
                                $.notify({
                                    icon: 'fad fa-info', title: '',
                                    message: response.error, 
                                },notify_setting);
                            }
                        },
                        success: function(data){},
                    });
                }
            }
        });
    });

    $('.btn_disable').click(function(){
        var btn = $(this);
        var name = $(this).attr('name');
        var status = $(this).attr('status');
        var record_id = $(this).attr('row-id');
        var elm = $('.dataTable tr[row-id="'+record_id+'"]');
        var question = status==1 ? `آیا دسترسی "${name}" فعال شود؟` : `آیا دسترسی "${name}" غیرفعال شود؟`;
        Swal.fire({
            title: "", text: question, type: "question", showCancelButton: true, buttonsStyling: false,
            confirmButtonClass: "btn btn-danger m-1", confirmButtonText: "بله",
            cancelButtonClass: "btn btn-secondary m-1", cancelButtonText: "خیر"
        }).then((result)=>{
            if(result.value){
                load_screen(true);
                $.ajax({
                    url: "{{url('admin/roles')}}/"+record_id+"/disable", type: "post", dataType: "json", cache: false, contentType: false, processData: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    complete: function(response){
                        load_screen(false);
                        response = JSON.parse(response.responseText);
                        if(response.success){
                            switch(response.state){
                                case 1:
                                    elm.children('td:nth-child('+(elm.children('td').length-1)+')').find('.badge[ban]').removeClass('badge-success').addClass('badge-danger').text('غیرفعال');
                                    btn.html('<i class="far fa-check"></i>');
                                    btn.attr('status',1);
                                    notify_setting.type = 'danger';
                                    $.notify({
                                        icon: 'fad fa-ban', title: '',
                                        message: 'دسترسی '+response.model.name+' غیرفعال شد',
                                    },notify_setting);
                                    break;
                                case 0:
                                    elm.children('td:nth-child('+(elm.children('td').length-1)+')').find('.badge[ban]').removeClass('badge-danger').addClass('badge-success').text('فعال');
                                    btn.html('<i class="far fa-ban"></i>');
                                    btn.attr('status',0);
                                    notify_setting.type = 'success';
                                    $.notify({
                                        icon: 'fad fa-check', title: '',
                                        message: 'دسترسی '+response.model.name+' فعال شد',
                                    },notify_setting);
                                    break;
                            }
                        }else{
                            Swal.fire({title: '', text: response.error, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});
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
            }
        });
    });

    $('select[name="status_filter"]').change(function(){
        var status_filter = $(this).val();

        var url = window.location.href+'?';
        window.location.href = url.slice(0,url.indexOf('?'))+'?status_filter='+status_filter;
    });

</script>
@endsection
