<div class="col-3 m-2">
    <div class="card text-right">
        <div class="card-body">
            <div class="cart-title">منوی مدیریت</div>
            <ul class="nav flex-column">
                <li class="nav-item nav-link"><a href="{{route('user.index')}}" class="active">صفحه اول</a></li>
                <li class="nav-item nav-link"><a href="{{route('user.notifications')}}" class="active">پیام ها</a></li>
                <li class="nav-item nav-link"><a href="{{route('post.manage')}}"> پست ها</a></li>
                <li class="nav-item nav-link"><a href="{{route('user.userPost')}}">تایید پست های کاربر</a></li>
                <li class="nav-item nav-link"><a href="{{route('user.profile')}}">تغییر اطلاعات کاربری</a></li>
                <li class="nav-item nav-link"><a href="{{route('user.newUser')}}">ایجاد کاربر جدید</a></li>
            </ul>
        </div>
    </div>
</div>