<?php $current_route = str_replace(url('/'),'',url()->current()); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> @yield('title') </title>
        <link rel="icon" href="<?=asset('img/logo.png')?>" type="image/png">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{asset('fontawsome/releases/v0.0.0/css/pro.min.css')}}">

        @if(App::isLocale('fa'))
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css" rel="stylesheet">
        @endif

        @yield('css')
        
        <link rel="stylesheet" href="{{asset('assets3/vendor/animate.css/animate.min.css')}}" type="text/css">
        <link rel="stylesheet" href="{{asset('assets3/css/argon.min.css?v=1.1.0')}}" type="text/css">
        <link rel="stylesheet" href="{{asset('assets3/css/admin3.css')}}" type="text/css">

        @if(App::isLocale('fa'))
        <link rel="stylesheet" href="{{asset('assets3/css/admin3_rtl.css')}}" type="text/css">
        @endif
        
        {{-- <link rel="stylesheet" href="{{asset('assets3/css/admin3_light.css')}}" type="text/css"> --}}

    </head>
    <body class="g-sidenav-pinned {{App::isLocale('fa')?'rtl':''}} bg-white" data-gr-c-s-loaded="true">
        
        <nav class="sidenav navbar navbar-vertical {{App::isLocale('fa')?'fixed-right':'fixed-left'}} navbar-expand-xs navbar-dark bg-white p-0" id="sidenav-main">
            <!-- Brand -->
            <div class="sidenav-header d-flex flex-md-column align-items-center justify-content-center">
                <a class="navbar-brand p-1" href="{{url('/')}}">
                    <img src="{{asset('img/'.$panel_settings->logo)}}" class="navbar-brand-img" alt="...">
                </a>
                <h1 class="m-0 p-2 text-light">{{$panel_settings->title}}</h1>
                <div class="ml-auto d-none">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/home'?'active':''}}" href="<?=url('admin')?>"> <i class="fad fa-chart-area text-green"></i><span class="nav-link-text">داشبورد</span> </a>
                        </li>
                        @canany(['admin.browse','role.browse','permission.browse'])
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/admins'||$current_route=='/admin/roles'||$current_route=='/admin/permissions'?'active':''}}" href="#navbar-admins" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-admins">
                                <i class="fad fa-users-crown text-yellow"></i><span class="nav-link-text">مدیریت ادمین</span>
                            </a>
                            <div class="collapse {{$current_route=='/admin/admins'||$current_route=='/admin/roles'||$current_route=='/admin/permissions'?'show':''}}" id="navbar-admins">
                                <ul class="nav nav-sm flex-column">
                                    @can('admin.browse') <li class="nav-item"><a href="<?=url('admin/admins')?>" class="nav-link {{$current_route=='/admin/admins'?'active':''}}"><i class="fad fa-user-shield text-yellow"></i> لیست ادمین ها</a></li> @endcan
                                    @can('role.browse') <li class="nav-item"><a href="<?=url('admin/roles')?>" class="nav-link {{$current_route=='/admin/roles'?'active':''}}"><i class="fad fa-user-tag text-yellow"></i> گروه بندی دسترسی</a></li> @endcan
                                    @can('permission.browse') <!-- <li class="nav-item"><a href="<?=url('admin/permissions')?>" class="nav-link {{$current_route=='/admin/permissions'?'active':''}}"><i class="fad fa-user-lock text-yellow"></i> تعریف دسترسی</a></li> --> @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @can('about_us.browse')
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/about_us'?'active':''}}" href="<?=url('admin/about_us');?>"><i class="fad fa-receipt text-orange"></i> <span class="nav-link-text">درباره ما</span></a>
                        </li>
                        @endcan
                        @can('panel_settings.browse')
                        <hr class="my-1 w-75 border-light">
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/panel_settings'?'active':''}}" href="<?=url('admin/panel_settings');?>"><i class="fad fa-sliders-h-square text-gray"></i> <span class="nav-link-text">تنظیمات پنل</span></a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </nav>

        <div class="main-content" id="panel">
            <!-- Topnav -->
            <nav class="navbar navbar-top navbar-expand navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <div class="sidenav-toggler sidenav-toggler-light ml-4 d-none d-xl-flex" data-action="sidenav-pin" data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>

                        <!-- Search form -->
                        <div class="navbar-search navbar-search-dark form-inline {{App::isLocale('fa')?'mr-sm-3':'ml-sm-3'}}" id="navbar-search-main">
                            <div class="form-group mb-0">
                                <div class="input-group input-group-alternative input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input class="form-control text-light" placeholder="جستجو" type="text">
                                </div>
                            </div>
                            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                                <span aria-hidden="true"><i class="fad fa-times-circle"></i></span>
                            </button>
                        </div>

                        <!-- Navbar links -->
                        <ul class="navbar-nav align-items-center ml-md-auto">
                            <li class="nav-item " removed_class="d-xl-none">
                                <!-- Sidenav toggler -->
                                
                            </li>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                    <i class="fad fa-search"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav align-items-center {{App::isLocale('fa')?'ml-0 mr-auto':'mr-0 ml-auto'}}">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fad fa-bell"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-xl {{App::isLocale('fa')?'dropdown-menu-left':'dropdown-menu-right'}} py-0 overflow-hidden">
                                    <div class="px-3 py-3">
                                        <h6 class="text-sm text-muted m-0">شما <strong class="text-primary">13</strong> پیام دارید</h6>
                                    </div>
                                    <div class="list-group list-group-flush">
                                        @for($i=0 ; $i<5 ; $i++)
                                        <a href="#!" class="list-group-item list-group-item-action">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <img alt="Image placeholder" src="{{asset('assets3/img/faces/avatar6.png')}}" class="avatar rounded-circle">
                                                </div>
                                                <div class="col ml-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div> <h4 class="mb-0 text-sm">John Snow</h4> </div>
                                                        <div class="text-right text-muted"> <small>2 ساعت پیش</small> </div>
                                                    </div>
                                                    <p class="text-sm mb-0">متن پیام اعلانیه نمایشی</p>
                                                </div>
                                            </div>
                                        </a>
                                        @endfor
                                    </div>
                                    <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link p-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media align-items-center {{App::isLocale('fa')?'':'flex-row-reverse'}}">
                                        <span class="avatar avatar-sm rounded-circle">
                                            <img alt="Image placeholder" src="{{$admin->avatar_image!=''?asset('img/admins/'.$admin->avatar_image):asset('assets3/img/faces/avatar6.png')}}">
                                        </span>
                                        <div class="media-body mr-2 d-none d-lg-block">
                                            <span class="mb-0 text-sm  font-weight-bold">{{$admin['name'].' '.$admin['family']}}</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu {{App::isLocale('fa')?'dropdown-menu-left':'dropdown-menu-right'}}">
                                    {{-- <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome!</h6>
                                    </div> --}}
                                    <a href="{{url('admin/profile')}}" class="dropdown-item"><i class="fad fa-user"></i><span>پروفایل</span></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{url('admin/logout')}}" class="dropdown-item text-danger"><i class="fad fa-sign-out"></i><span>خروج</span></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="load_screen"><span></span></div>

            <!-- Page content -->
            <div class="main_div container-fluid bg-secondary d-flex flex-column" style="min-height: calc(100vh - 80px);">
                @yield('content')

                <!-- Footer -->
                <footer class="footer p-1 mt-auto mb-0 border-top bg-secondary">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-start">
                                {{-- <li class="nav-item"><a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a></li> --}}
                                {{-- <li class="nav-item"><a href="https://demos.creative-tim.com/argon-dashboard-pro/docs/getting-started/overview.html" class="nav-link" target="_blank">Documention</a></li> --}}
                                <li class="nav-item"><a href="https://ratechcompany.com" class="nav-link" target="_blank">پشتیبانی راتک</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <div class="copyright text-muted text-center {{App::isLocale('fa')?'text-lg-left':'text-lg-right'}}">
                                © {{date('Y')}} <a href="https://ratechcompany.com" class="font-weight-bold" target="_blank">گروه راتک</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>


        <script src="{{asset('assets3/vendor/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('assets3/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets3/vendor/js-cookie/js.cookie.js')}}"></script>
        {{-- <script src="{{asset('assets3/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script> --}}
        {{-- <script src="{{asset('assets3/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script> --}}
        
        {{-- <script src="{{asset('assets3/vendor/chart.js/dist/Chart.min.js')}}"></script> --}}
        {{-- <script src="{{asset('assets3/vendor/chart.js/dist/Chart.extension.js')}}"></script> --}}
        
        <script src="{{asset('assets3/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

        <script src="{{asset('assets3/js/argon.min.js?v=1.1.0')}}"></script>
        <script src="{{asset('assets3/js/admin3.js')}}"></script>
        {{-- <script src="{{asset('assets3/js/demo.min.js')}}"></script> --}}

        @yield('javascript')

        <script>
            $('.sidenav-toggler').click(function(){
                if(!$('body').hasClass('g-sidenav-hidden')){
                    $('body').removeClass('g-sidenav-show');
                }
            });
            $('body').on('click','.backdrop',function(){
                $('body').removeClass('g-sidenav-show');
            });
            
            $('.sidenav').mouseenter(function(){
                if($(window).width() <= 1200){
                    $('body').addClass('g-sidenav-pinned').addClass('g-sidenav-show').removeClass('g-sidenav-hidden');
                }else{$('body').addClass('g-sidenav-show');}
                // document.cookie = "sidenav-state=pinned;";
            }).mouseleave(function(){
                if($(window).width() <= 1200){
                    $('body').removeClass('g-sidenav-pinned').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
                }else{$('body').removeClass('g-sidenav-hidden');}
            });

            $('#navbar-search-main input').keyup(function(e){
                if(e.keyCode == 13){
                    e.preventDefault();
                    var search_query = $(this).val();
                    if(search_query !=""){
                        var url = window.location.href+'?';
                        window.location.href = url.slice(0,url.indexOf('?'))+'?search='+search_query;
                    }
                }
            });
        </script>
    </body>
</html>