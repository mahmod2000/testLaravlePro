<!doctype html>
<html lang="fa">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * { font-family: IRANSans; }
        .row{
            width: 100%;
        }
        .col-4 {
            width: 50px !important;
            display: inline-block;
            border: 1px solid gray;
            margin: 5px 8px;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="row">
    <!-- Content Row -->
        @foreach($posts as $post)
        <div class="col-4">
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
        <!-- /.col-md-4 -->
        @endforeach
</div>
</body>
</html>