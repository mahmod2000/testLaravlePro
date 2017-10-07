@extends('layout')

@section('page-title', 'پنل مدیریت')
@section('meta-desc', 'پنل مدیریت')
@section('meta-keyword', 'پنل مدیریت')

@section('content')
    @include('admin.includes.navbar')

    <div class="col-8 p-3">
        <div class="card m-4 p-3 text-right">
            <div class="body">بخش مدیریت</div>
        </div>
    </div>
@endsection