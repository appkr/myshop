@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">CUSTOMER Register</div>
        <div class="panel-body">
          <form class="form-horizontal"
                role="form"
                method="POST"
                action="{{ route('customers.register.submit') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">
                이름
              </label>

              <div class="col-md-6">
                <input id="name"
                       type="text"
                       class="form-control"
                       name="name"
                       value="{{ old('name', request('name')) }}"
                       autofocus>
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">
                이메일
              </label>

              <div class="col-md-6">
                <input
                  id="email"
                  type="email"
                  class="form-control"
                  name="email"
                  value="{{ old('email', request('email')) }}">
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">
                비밀번호
              </label>

              <div class="col-md-6">
                <input
                  id="password"
                  type="password"
                  class="form-control"
                  name="password">

                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group">
              <label for="password-confirm"
                     class="col-md-4 control-label">
                비밀번호 확인
              </label>

              <div class="col-md-6">
                <input id="password-confirm"
                       type="password"
                       class="form-control"
                       name="password_confirmation">
              </div>
            </div>

            <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
              <label for="zipcode" class="col-md-4 control-label">
                우편번호
              </label>

              <div class="col-md-6">
                <input
                  id="zipcode"
                  type="text"
                  class="form-control"
                  name="zipcode"
                  value="{{ old('zipcode') }}">

                {!! $errors->first('zipcode', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
              <label for="address" class="col-md-4 control-label">
                주소
              </label>

              <div class="col-md-6">
                <input
                  id="address"
                  type="text"
                  class="form-control"
                  name="address"
                  value="{{ old('address') }}">

                {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
              <label for="phone_number" class="col-md-4 control-label">
                전화번호
              </label>

              <div class="col-md-6">
                <input
                  id="phone_number"
                  type="text"
                  class="form-control"
                  name="phone_number"
                  value="{{ old('phone_number') }}">

                {!! $errors->first('phone_number', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
              <label for="date_of_birth" class="col-md-4 control-label">
                생년월일
              </label>

              <div class="col-md-6">
                <input
                  id="date_of_birth"
                  type="text"
                  class="form-control"
                  name="date_of_birth"
                  value="{{ old('date_of_birth') }}">

                {!! $errors->first('date_of_birth', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
              <div class="radio">
                <label class="col-md-4 control-label">
                  <input type="radio" name="gender" id="gender"
                         value="MALE" {{ old('gender') == 'MALE' ? 'checked' : '' }}>
                  남자
                </label>
              </div>
              <div class="radio">
                <label class="col-md-4 control-label">
                  <input type="radio" name="gender" id="gender"
                         value="FEMALE" {{ old('gender') == 'FEMALE' ? 'checked' : '' }}>
                  여자
                </label>
              </div>
              {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
            </div>

            <div class="form-group {{ $errors->has('profile') ? 'has-error' : '' }}">
              <label for="profile" class="col-md-4 control-label">
                자기소개
              </label>
              <div class="col-md-6">
                <textarea name="profile" id="content" rows="10" class="form-control">{{ old('profile') }}</textarea>
                {!! $errors->first('profile', '<span class="form-error">:message</span>') !!}
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Register
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
