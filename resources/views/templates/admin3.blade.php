<?php $current_route = str_replace(url('/'),'',url()->current()); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> @yield('title') </title>
        <link rel="icon" href="<?=asset('img/logo.png')?>" type="image/png">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{asset('fontawsome.5.10.1/releases/v5.10.1/css/pro.min.css')}}">

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
                <a class="navbar-brand p-1" href="../../pages/dashboards/dashboard.html">
                    <img src="{{asset('img/logo.png')}}" class="navbar-brand-img" alt="...">
                </a>
                <h1 class="m-0 p-2 text-light">گروه راتک</h1>
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
                                    @can('role.browse') <li class="nav-item"><a href="<?=url('admin/roles')?>" class="nav-link {{$current_route=='/admin/roles'?'active':''}}"><i class="fad fa-user-tag text-yellow"></i> تعریف نقش</a></li> @endcan
                                    @can('permission.browse') <li class="nav-item"><a href="<?=url('admin/permissions')?>" class="nav-link {{$current_route=='/admin/permissions'?'active':''}}"><i class="fad fa-user-lock text-yellow"></i> تعریف دسترسی</a></li> @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @canany(['user_group.browse','customer.browse'])
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/customers_group'||$current_route=='/admin/customers'?'active':''}}" data-toggle="collapse" href="#navbar-customer" role="button" aria-expanded="false" aria-controls="navbar-customer">
                                <i class="fad fa-user text-blue"></i> <span class="nav-link-text">مدیریت مشتریان</span>
                            </a>
                            <div class="collapse {{$current_route=='/admin/customers_group'||$current_route=='/admin/customers'?'show':''}}" id="navbar-customer">
                                <ul class="nav nav-sm flex-column">
                                    @can('user_group.browse') <li class="nav-item"><a href="<?=url('admin/customers_group');?>" class="nav-link {{$current_route=='/admin/customers_group'?'active':''}}"><i class="fad fa-users text-blue"></i> گروه مشتریان</a></li> @endcan
                                    @can('customer.browse') <li class="nav-item"><a href="<?=url('admin/customers');?>" class="nav-link {{$current_route=='/admin/customers'?'active':''}}"><i class="fad fa-user text-blue"></i> لیست مشتریان</a></li> @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @canany(['user_group.browse','teacher.browse'])
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/teachers_group'||$current_route=='/admin/teachers'?'active':''}}" data-toggle="collapse" href="#navbar-teacher" role="button" aria-expanded="false" aria-controls="navbar-teacher">
                                <i class="fad fa-chalkboard-teacher text-purple"></i> <span class="nav-link-text">مدیریت اساتید</span>
                            </a>
                            <div class="collapse {{$current_route=='/admin/teachers_group'||$current_route=='/admin/teachers'?'show':''}}" id="navbar-teacher">
                                <ul class="nav nav-sm flex-column">
                                    @can('user_group.browse') <li class="nav-item"><a href="<?=url('admin/teachers_group');?>" class="nav-link {{$current_route=='/admin/teachers_group'?'active':''}}"><i class="fad fa-users-class text-purple"></i> گروه اساتید</a></li> @endcan
                                    @can('teacher.browse') <li class="nav-item"><a href="<?=url('admin/teachers');?>" class="nav-link {{$current_route=='/admin/teachers'?'active':''}}"><i class="fad fa-chalkboard-teacher text-purple"></i> لیست اساتید</a></li> @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @canany(['course_group.browse','course.browse'])
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/course_groups'||$current_route=='/admin/courses'?'active':''}}" data-toggle="collapse" href="#navbar-course" role="button" aria-expanded="false" aria-controls="navbar-course">
                                <i class="fad fa-book text-pink"></i> <span class="nav-link-text">مدیریت دوره ها</span>
                            </a>
                            <div class="collapse {{$current_route=='/admin/course_groups'||$current_route=='/admin/courses'?'show':''}}" id="navbar-course">
                                <ul class="nav nav-sm flex-column">
                                    @can('course_group.browse') <li class="nav-item"><a href="<?=url('admin/course_groups');?>" class="nav-link {{$current_route=='/admin/course_groups'?'active':''}}"><i class="fad fa-box text-pink"></i> گروه بندی دوره ها</a></li> @endcan
                                    @can('course.browse') <li class="nav-item"><a href="<?=url('admin/courses');?>" class="nav-link {{$current_route=='/admin/courses'?'active':''}}"><i class="fad fa-book text-pink"></i> تعریف دوره ها</a></li> @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @canany(['course_payment','commission.browse','discount.browse','promo_code.browse'])
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/course_payments'||$current_route=='/admin/commissions'||$current_route=='/admin/discounts'||$current_route=='/admin/promo_codes'?'active':''}}" data-toggle="collapse" href="#navbar-finance" aria-expanded="false">
                                <i class="fad fa-usd-circle text-red"></i> <span class="nav-link-text">مدیریت مالی</span>
                            </a>
                            <div class="collapse {{$current_route=='/admin/course_payments'||$current_route=='/admin/commissions'||$current_route=='/admin/discounts'||$current_route=='/admin/promo_codes'?'show':''}}" id="navbar-finance">
                                <ul class="nav nav-sm flex-column">
                                    @can('course_payment.browse') <li class="nav-item"><a class="nav-link {{$current_route=='/admin/course_payments'?'active':''}}" href="<?=url('admin/course_payments');?>"><i class="fad fa-box-usd text-red"></i> پرداختی دوره ها</a></li> @endcan
                                    @can('commission.browse') <li class="nav-item"><a class="nav-link {{$current_route=='/admin/commissions'?'active':''}}" href="<?=url('admin/commissions');?>"><i class="fad fa-envelope-open-dollar text-red"></i> تعریف کمیسیون ها</a></li> @endcan
                                    @can('discount.browse') <li class="nav-item "><a class="nav-link {{$current_route=='/admin/discounts'?'active':''}}" href="<?=url('admin/discounts');?>"><i class="fad fa-percent text-red"></i> مدیریت تخفیف ها</a></li> @endcan
                                    @can('promo_code.browse') <li class="nav-item "><a class="nav-link {{$current_route=='/admin/promo_codes'?'active':''}}" href="<?=url('admin/promo_codes');?>"><i class="fad fa-tags text-red"></i> تعریف بن های تخفیف</a></li> @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @canany(['usance_list.browse','usance_payment.browse','usance_type.browse'])
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/usance_types'||$current_route=='/admin/usance_lists'||$current_route=='/admin/usance_payments'?'active':''}}" data-toggle="collapse" href="#navbar-usance" aria-expanded="false">
                                <i class="fad fa-file-contract text-cyan"></i> <span class="nav-link-text">مدیریت سررسیدها</span>
                            </a>
                            <div class="collapse {{$current_route=='/admin/usance_types'||$current_route=='/admin/usance_lists'||$current_route=='/admin/usance_payments'?'show':''}}" id="navbar-usance">
                                <ul class="nav nav-sm flex-column">
                                    @can('usance_type.browse') <li class="nav-item"><a class="nav-link {{$current_route=='/admin/usance_types'?'active':''}}" href="<?=url('admin/usance_types');?>"><i class="fad fa-file-contract text-cyan"></i> تنظیمات سررسید</a></li> @endcan
                                    @can('usance_list.browse') <li class="nav-item "><a class="nav-link {{$current_route=='/admin/usance_lists'?'active':''}}" href="<?=url('admin/usance_lists');?>"><i class="fad fa-file-invoice text-cyan"></i> لیست سررسیدها</a></li> @endcan
                                    @can('usance_payment.browse') <li class="nav-item "><a class="nav-link {{$current_route=='/admin/usance_payments'?'active':''}}" href="<?=url('admin/usance_payments');?>"><i class="fad fa-file-invoice-dollar text-cyan"></i> پرداختی های سررسید</a></li> @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @can('blog.browse')
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/blogs'?'active':''}}" href="<?=url('admin/blogs');?>"><i class="fad fa-newspaper text-gray"></i> <span class="nav-link-text">مقالات</span></a>
                        </li>
                        @endcan
                        @can('comment.browse')
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/comments'?'active':''}}" href="<?=url('admin/comments');?>"><i class="fad fa-comments text-teal"></i> <span class="nav-link-text">نظرات کاربران</span></a>
                        </li>
                        @endcan
                        @can('faq.browse')
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/faqs'?'active':''}}" href="<?=url('admin/faqs');?>"><i class="fad fa-question-circle text-light"></i> <span class="nav-link-text">سوالات متداول</span></a>
                        </li>
                        @endcan
                        @can('about_us.browse')
                        <li class="nav-item">
                            <a class="nav-link {{$current_route=='/admin/about_us'?'active':''}}" href="<?=url('admin/about_us');?>"><i class="fad fa-receipt text-orange"></i> <span class="nav-link-text">درباره ما</span></a>
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
                        <form class="navbar-search navbar-search-dark form-inline mr-sm-3" id="navbar-search-main">
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
                        </form>

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
                        <ul class="navbar-nav align-items-center ml-0 mr-auto">
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
                                    <div class="media align-items-center">
                                        <span class="avatar avatar-sm rounded-circle">
                                            <img alt="Image placeholder" src="{{$admin->avatar_image!=''?asset('img/admins/'.$admin->avatar_image):asset('assets3/img/faces/avatar6.png')}}">
                                        </span>
                                        <div class="media-body mr-2 d-none d-lg-block">
                                            <span class="mb-0 text-sm  font-weight-bold">{{$admin['name']}}</span>
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
                            <div class="copyright text-muted text-center text-lg-left" removed_class="text-center text-lg-left">
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
        </script>
    </body>
</html>