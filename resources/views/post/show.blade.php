@extends('layout')

@section('content')

        <!-- Post Content Column -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4">{{$post->title}}</h1>

            <!-- Author -->
            {{--<p class="lead">--}}
                {{--توسط--}}
                {{--<a href="#">{{$post->user->name}}</a>--}}
            {{--</p>--}}

            <hr>

            <!-- Date/Time -->
            <p>ثبت شده در {{verta($post->created_at)->formatDifference()}}</p>

            <hr>

            <!-- Preview Image -->
            <img class="img-fluid rounded" src="@if($post->image != '') {{URL::to('/').'/images/post/'.$post->image}} @else  http://placehold.it/900x300 @endif" alt="">

            <hr>

            <!-- Post Content -->
            {!!  $post->title !!}

            <hr>

            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">ثبت یک نظر:</h5>

                @include('messages.message')

                <div class="card-body">
                    <form action="{{route('comment.store')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <div class="form-group">
                            <label for="name" class="label">نام: </label>
                            <input type="text" name="name" id="name" placeholder="نام شما..." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="label"> ایمیل: <small>(نمایش داده نمیشود)</small>  </label>
                            <input type="email" name="email" id="email" placeholder="ایمیل شما..." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment" class="label"> پیام:  </label>
                            <textarea id="comment" name="comment" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </form>
                </div>
            </div>

            <!-- Single Comment -->
            @foreach($post->comments as $comments)
            <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                <div class="media-body">
                    <div class="text-left">{{verta($comments->created_at)->format('%B %d, %y')}}</div>
                    <h5 class="mt-0">{{$comments->name}}</h5>
                    {{$comments->comment}}
                </div>
            </div>
            @endforeach

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">جستجو</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="جستجو...">
                        <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button">برو!</button>
                </span>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">اطلاعات کاربر</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <p>  {{$post->user->name}} ({{$post->user->email}})</p>
                            <p>@if(!empty($post->user->image)) <img class="img-thumbnail" src="{{URL::to('/').'/images/user/'.$post->user->image}}" alt=""> @endif</p>
                        </div>
                    </div>
                </div>
            </div>

@endsection