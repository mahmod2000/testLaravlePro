@extends('layout')

@section('content')
<div class="col-12 text-right p-3">
    <div class="card">
        <div class="card-title p-3">ورود کاربر</div>

        <div class="cart-body p-2">
            <div class="col-4 col-auto">
                 <a href="{{route('auth.googleLogin')}}"> <i class="fa fa-google fa-2x" aria-hidden="true"></i>  </a> <span>ورود با اکانت گوگل </span>
            </div>
            <hr>
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">ایمیل</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">رمز عبور</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> به خاصر بسپار
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            ورود
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                           رمز ورود را فراموش کردید؟
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
