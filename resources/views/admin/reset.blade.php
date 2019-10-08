@extends('templates.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>تغییر رمزعبور</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal form-info" role="form" method="POST" action="{{ url('/admin/password/reset') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">ایمیل</label>
                            <div class="input-group-icon input-group-icon-left mb-4">
                                <span class="input-icon input-icon-left"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" autofocus>
                            </div>
                            @if($errors->has('email'))
                                <strong>{{ $errors->first('email') }}</strong>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">رمزعبور</label>
                            <div class="input-group-icon input-group-icon-left mb-4">
                                <span class="input-icon input-icon-left"><i class="fas fa-envelope"></i></span>
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                            @if($errors->has('password'))
                                <strong>{{ $errors->first('password') }}</strong>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">تکرار رمزعبور</label>
                            <div class="input-group-icon input-group-icon-left mb-4">
                                <span class="input-icon input-icon-left"><i class="fas fa-envelope"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                            @if($errors->has('password_confirmation'))
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn">تغییر رمزعبور</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
