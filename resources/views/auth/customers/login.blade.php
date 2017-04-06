@extends('layouts.app')

@section('style')
  <style>
    .login-or {
      position: relative;
      margin-top: 20px;
      margin-bottom: 20px;
      padding-top: 15px;
      padding-bottom: 15px;
    }

    .span-or {
      display: block;
      position: absolute;
      left: 50%;
      top: 5px;
      background-color: #fff;
      margin-left: -25px;
      width: 50px;
      text-align: center;
    }

    .hr-or {
      margin-top: 0px !important;
      margin-bottom: 0px !important;
    }

    .fa-facebook {
      margin-right: 10px;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">CUSTOMER Login</div>
        <div class="panel-body">
          <form class="form-horizontal"
                role="form"
                method="POST"
                action="{{ route('customers.login.submit') }}">
            {{ csrf_field() }}

            <div class="form-group">
              <div class="col-md-offset-4 col-md-6">
                <a
                  class="btn btn-default btn-lg btn-block"
                  href="{{ route('customers.social.login', ['facebook']) }}">
                  <strong>
                    <i class="fa fa-facebook"></i>
                    페이스북으로 로그인
                  </strong>
                </a>
              </div>
            </div>

            <div class="login-or">
              <hr class="hr-or">
              <span class="span-or">or</span>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">
                E-Mail Address
              </label>

              <div class="col-md-6">
                <input id="email"
                       type="email"
                       class="form-control"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus>
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">
                Password
              </label>

              <div class="col-md-6">
                <input id="password"
                       type="password"
                       class="form-control"
                       name="password"
                       required>
                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"
                           name="remember"
                      {{ old('remember') ? 'checked' : '' }}>
                    Remember Me
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Login
                </button>

                <a class="btn btn-link"
                   href="{{ route('password.request') }}">
                  Forgot Your Password?
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
