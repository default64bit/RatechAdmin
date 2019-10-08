@extends('templates.admin3')

@section('css')
<link rel="stylesheet" href="{{asset('assets3/vendor/animate.css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">

<link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">لیست ادمین ها</h6>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">لیست ادمین ها</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card pr-3 pl-3">
            <div class="col-12 p-0 py-3 d-flex align-items-center justify-content-between">
                @can('admin.add')
                <a class="btn_add btn btn-success" href="{{url('admin/admins/create')}}"><i class="far fa-plus"></i> ادمین جدید </a>
                @endcan
                
            </div>
            <div class="table-responsive">
                <div class="table-responsive pb-4">
                    <table class="table table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>ردیف</th>
                                <th>نام</th>
                                <th>نام کاربری</th>
                                <th>زمان ثبت</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = ($admins->currentpage()-1) * $admins->perpage(); $i++; ?>
                            @foreach($admins as $admin_detail)
                            <tr row-id="{{$admin_detail->id}}">
                                <td>{{$i++}}</td>
                                <td>{{$admin_detail->name}}</td>
                                <td>{{$admin_detail->username}}</td>
                                <td>{{$admin_detail->created_at}}</td>
                                <td>
                                    @can('admin.edit') <a class="table-action text-info" data-toggle="tooltip" data-original-title="ویرایش" href="{{url('admin/admins/'.$admin_detail->id.'/edit')}}"><i class="far fa-edit"></i></a> @endcan
                                    @can('admin.delete') <a class="table-action btn_delete text-danger" data-toggle="tooltip" data-original-title="حذف" row-id="{{$admin_detail->id}}"><i class="far fa-trash-alt"></i></a> @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12">
                {{$admins->links()}}
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

<script>
    var table = $('#datatable').DataTable({
        paging: false, pageLength: 200,
        fixedHeader: true, responsive: true,
        "sDom": 'rtip',
        columnDefs: [{
            targets: 'no-sort', orderable: false
        }],
        "order": [[0, "desc"]],
        "language": {"info": "نمایش _START_ تا _END_ ردیف (از _TOTAL_ رکورد)"}
    });
    $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
    });
    $('.navbar-search input').attr('placeholder','جستجو ادمین ها');

    $('.btn_delete').click(function(){
        var record_id = $(this).attr('row-id');
        var elm = $('.dataTable tr[row-id="'+record_id+'"]');
        Swal.fire({
            title: "", text: "ادمین انتخابی حذف شود؟", type: "question", showCancelButton: true, buttonsStyling: false,
            confirmButtonClass: "btn btn-danger m-1", confirmButtonText: "بله",
            cancelButtonClass: "btn btn-secondary m-1", cancelButtonText: "خیر"
        }).then((result)=>{
            if(result.value){
                load_screen(true);
                $.ajax({
                    url: "{{url('admin/admins')}}/"+record_id, type: "delete", cache: false, contentType: false, processData: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    complete: function(response){
                        load_screen(false);
                        response = JSON.parse(response.responseText);
                        if(response.success){
                            table.row(elm).remove().draw();
                            Swal.fire({title: '', text: "ادمین انتخابی حذف شد.", type: "success", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});
                        }else{
                            Swal.fire({title: '', text: response.error, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false});
                        }
                    },
                    success: function(data){},
                    error: function(data){ Swal.fire({title: data.responseText, type: "error", confirmButtonText: "خٌب", confirmButtonClass: "btn btn-outline-default", buttonsStyling: false}); }
                });
            }
        });
    });
</script>
@endsection
