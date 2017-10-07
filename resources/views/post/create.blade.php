@extends('layout')

@section('content')
    @include('user.user-navbar')
    <div class="col-8 p-3">
    <div class="card">
        <div class="card-body">
            <h1>ایجاد پست جدید</h1>
            @include('messages.errors')
            @include('messages.message')
            <form action="{{route('post.store')}}" id="FormPost" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="title" class="label">عنوان</label>
                    <input type="text" class="form-control" id="title" name="title">
                    <small id="error_title" class="error_messages text-danger" style="display: none">عنوان مورد نیاز است</small>
                </div>
                <div class="form-group">
                    <label for="image" class="label">آپلود عکس</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="content" class="label">متن</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                    <small id="error_content" class="error_messages text-danger" style="display: none">متن مورد نیاز است</small>
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
            var title = $('#title').val();
            var content = $('#content').val();

           if($.trim(title) == '')
           {
               $("#error_title").show();
               errors = true;
           }

           if($.trim(content) == '')
           {
               $("#error_content").show();
               errors = true;
           }

           if(errors) e.preventDefault();
           else return true;
        }
    </script>
@endsection