@extends('layout')

@section('page-title', 'ایجاد کاربر جدید')
@section('meta-desc', 'ایجاد کاربر جدید')
@section('meta-keyword', 'ایجاد کاربر جدید')

@section('content')
    @include('user.user-navbar')
    <div class="col-8 p-3">
    <div class="card">
        <div class="card-title p-3">ایجاد کاربر جدید</div>

        @include('messages.errors')
        @include('messages.message')

        <div class="card-body">
            <form action="{{route('user.createUser')}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="parent" value="{{Auth()->id()}}">
                <div class="form-group">
                    <label for="name" class="form-control-label">نام کاربر</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="email" class="form-control-label">ایمیل کاربر</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label for="password" class="form-control-label">پسوورد کاربر</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">سطح دسترسی:</label>
                @foreach($roles as $role)
                    @if($role->name != 'superadministrator')
                        <div class="col-3 form-check">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="roles[]" value="{{$role->id}}"> <span class="text-checkbox">{{$role->display_name}}</span>
                            </label>
                        </div>
                    @endif
                @endforeach
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">ثبت</button>
                </div>

            </form>
        </div>
    </div>
    </div>
@endsection