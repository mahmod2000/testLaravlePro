@extends('layout')

@section('content')
    @include('user.user-navbar')
    <div class="col-8 p3">
    <div class="card">
        <div class="card-body">
            <h1>ویرایش اطلاعات</h1>
            <div class="mt-3 mb-3"><a href="{{route('user.backup', $user->id)}}" class="btn btn-warning">تهیه بک آپ از اطلاعات خود</a></div>
            <span class="card">
                <div class="card-header p-2">بازیابی اطلاعات</div>
                <form class="ml-3" action="{{route('user.restore')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$user->id}}" name="user_id">
                        <div class="form-group">
                            <label for="" class="form-check-label"></label>
                            <input type="file" name="file_restore" id="file_restore" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-dark btn-sm ">آپلود</button>
                        </div>
                </form>
            </span>
            @include('messages.errors')
            @include('messages.message')
            <hr>
            <form action="{{route('user.updateProfile', $user->id)}}" id="FormPost" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PATCH')}}
                <div class="form-group">
                    <label for="name" class="label">عنوان</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                    <small id="error_name" class="error_messages text-danger" style="display: none">نام مورد نیاز است</small>
                </div>
                <div class="form-group">
                    <label for="email" class="label">ایمیل</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                    <small id="error_email" class="error_messages text-danger" style="display: none">ایمیل مورد نیاز است</small>
                </div>
                <div class="form-group">
                    <label for="image" class="label">آپلود عکس</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    @if(!empty($user->image))
                        <div class="img-thumbnail">
                            <img src="{{URL::to('/').'/images/user/'.$user->image}}" alt="{{$user->name}}">
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"  onclick="submitForm(event)">ثبت</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        function submitForm(e)
        {
            // hide messages
            $(".error_messages").hide();

            var errors = false;
            var name = $('#name').val();
            var email = $('#email').val();

            if($.trim(name) == '')
            {
                $("#error_name").show();
                errors = true;
            }

            if($.trim(email) == '')
            {
                $("#error_email").show();
                errors = true;
            }

            if(errors) e.preventDefault();
            else return true;
        }
    </script>
@endsection