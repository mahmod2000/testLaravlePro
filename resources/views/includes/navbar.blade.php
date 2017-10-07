<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">پروژه تست</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">صفحه اصلی
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">درباره ما</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">خدمات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">تماس با ما</a>
                </li>
            </ul>
                <ul class="navbar-nav">
                    @if(!auth()->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('login')}}">ورود</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('register')}}">ثبت نام</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.index')}}">پنل کاربری</a>
                        </li>
                    @if(auth()->user()->hasRole('superadministrator'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.index')}}">پنل مدیریت</a>
                            </li>
                    @endif
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="$('#form_logout').submit()">خروج</a>
                            <form action="{{route('logout')}}" style="display: none" method="POST" id="form_logout">
                                {{csrf_field()}}
                            </form>
                        </li>
                    @endif
                </ul>
        </div>
    </div>
</nav>