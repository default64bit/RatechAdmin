@extends('templates.auth3')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel card bg-secondary">
                <div class="panel-heading title">
                    <img src="{{asset('img/'.$panel_settings->logo)}}" alt="">
                    <h2>{{$panel_settings->title}}</h2>
                </div>
                <div class="panel-body card-body">
                    <form class="form-horizontal form-info" role="form" method="POST" action="{{ url('/admin/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="email" class="control-label">ایمیل یا نام کاربری</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fad fa-envelope"></i></span>
                                </div>
                                <input id="email" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus>
                            </div>
                            @if($errors->has('email'))
                            <strong class="alert p-2 alert-danger"><i class="fad fa-exclamation-circle"></i> {{$errors->first('email')}}</strong>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">رمزعبور</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fad fa-lock"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                            @if($errors->has('password'))
                            <strong class="alert p-2 alert-danger"><i class="fad fa-exclamation-circle"></i> {{$errors->first('password')}}</strong>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox-light custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                                <label class="custom-control-label" for="remember">مرا به خاطر بسپار</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-light w-100">ورود</button>
                            {{-- <a class="btn btn-link" href="{{ url('/admin/password/reset') }}">فراموشی رمزعبور</a> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
