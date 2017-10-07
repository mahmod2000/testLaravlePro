@extends('layout')

@section('content')

    @include('includes.heading', $posts)

    @include('includes.actionBar')

    <!-- Content Row -->
        @foreach($posts as $post)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">{{$post->title}}</h2>
                    <p class="card-text">{{$post->content}}</p>
                </div>
                <div class="card-footer text-left">
                    <a href="{{route('post.show', $post)}}" class="btn btn-primary">اطلاعات بیشتر</a>
                </div>
            </div>
        </div>
        @endforeach
        <!-- /.col-md-4 -->
    <!-- /.row -->

    <!-- pagination -->
    <div class="col-12">
            {{$posts->render()}}
    </div>
@endsection