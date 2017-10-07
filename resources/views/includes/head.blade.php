<title>@yield('page-title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="@yield('meta-desc')">
<meta name="keywords" content="@yield('meta-keyword')">
<meta name="csrf-token" content="{{csrf_token()}}">

@yield('meta')


<link rel="stylesheet" href="{{asset('/css/app.css')}}">
<link rel="stylesheet" href="{{asset('/css/rtl.css')}}">