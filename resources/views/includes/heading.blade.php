
<!-- Heading Row -->
@if ($posts->first())
<div class="row my-4">
    <div class="col-lg-8">
        <img class="img-fluid rounded" src="http://placehold.it/900x400" alt="">
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <h1 class="text-right">{{$posts->first()->title}}</h1>
        <p class="text-right">{{$posts->first()->content}}</p>
        <a class="btn btn-primary btn-lg" href="#">اطلاعات بیشتر</a>
    </div>
    <!-- /.col-md-4 -->
</div>
@endif
<!-- /.row -->