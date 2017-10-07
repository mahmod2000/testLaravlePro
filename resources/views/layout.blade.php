<!DOCTYPE html>
<html lang="en">

<head>

@include('includes.head')

</head>

<body>

<!-- Navigation -->
@include('includes.navbar')

<!-- Page Content -->
<div class="container" id="app">
    <div class="row text-right">
    @section('content')
        @show
    </div>

</div>
<!-- /.container -->

@include('includes.footer')

<script src="{{asset('/js/app.js')}}"></script>
@yield('scripts')
<script>
    $(document).ready(function () {
        $('.show-message').fadeOut(4000);
    });
</script>
</body>

</html>
