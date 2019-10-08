@extends('templates.admin3')

@php
    session()->put('counter',0);
@endphp

@section('title')
راتک
@endsection

@section('css')
@endsection

@section('dialogs')
@endsection

@section('content')
<div class="header">
    <h6 class="h2 mb-0 mt-3">داشبورد</h6>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-2">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">داشبورد</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{asset('assets3/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('assets3/vendor/chart.js/dist/Chart.extension.js')}}"></script>
<script>
    $(document).ready(function(){
        notify_setting.type = 'info';
        $.notify({
            icon: 'fad fa-check',
            title: 'عنوان',
            message: 'متن پیام' 
        },notify_setting);
    });
</script>
@endsection
