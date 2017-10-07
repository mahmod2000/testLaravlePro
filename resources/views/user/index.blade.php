@extends('layout')

@section('content')
    @include('user.user-navbar')

    <div class="col-8 p-3">
        <div class="card p-3">
            <div class="card-title p-4">کاربری</div>
            <div class="card-body p-4">
                پنل کاربری {{auth()->user()->name}}
                <hr>

                <div>

                    <div class="blockquote">
                        بخش Passport authentication
                    </div>

                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                </div>
            </div>

        </div>
    </div>
@endsection