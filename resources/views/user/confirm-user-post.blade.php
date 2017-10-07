@extends('layout')

@section('page-title', 'تایید پست های کاربر')
@section('meta-desc', 'تایید پست های کاربر')
@section('meta-keyword', 'تایید پست های کاربر')

@section('content')
    @include('user.user-navbar')
    <div class="col-8 p-3">
    <div class="card">
        <div class="card-title p-3"> <h2>لیست پست ها</h2> </div>

        @include('messages.message')

        <div class="card-body">
            <div class="p-3"> <a class="btn btn-danger" href="javascript:void(0)" onclick="destroyAll()">
                <i class="fa fa-trash-o fa-lg"></i> حذف موارد انتخاب شده </a>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>تاریخ ایجاد</th>
                        <th>تایید شده</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr id="box_{{$post->id}}">
                        <td><label class="label"> <input type="checkbox" class="remove_checkbox" id="checkbox_{{$post->id}}" value="{{$post->id}}"> {{$post->id}} </label></td>
                        <td>{{$post->title}}</td>
                        <td>{{verta($post->created_at)->format('%B %d, %Y')}}</td>
                        <td>@if($post->confirm_admin_post) <i class="fa fa-check" aria-hidden="true"></i> @else <i class="fa fa-times" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="if(confirm('برای حذف این آیتم مطمئن هستید؟'))
                            {
                                removeOne({{$post->id}})
                            }">
                                <i class="fa fa-trash-o fa-lg"></i> حذف </a>
                            <a class="btn btn-primary btn-sm" href="{{route('user.userPostConfirm', $post->id)}}">
                                @if($post->confirm_admin_post == 0) <i class="fa fa-cog"></i> فعال کردن پست </a>
                                @else <i class="fa fa-cog"></i> غیر فعال کردن پست </a>
                                @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- pagination -->
            <div class="col-12">
                {{$posts->render()}}
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        function destroyAll()
        {
            var ids = '';

            $('.remove_checkbox').each(function (i, e) {
               if($(this).is(':checked'))  ids += $(this).val()+',';
            });

            if($.trim(ids) == '') return false;

            axios.post('/post/destroyAll', {
                'ids': ids
            }).then(function(data) {
                if(data.data['status'] == 1) window.location.reload();
            }).error(function (data) {
                console.log(data);
            });
        }

        function removeOne(id)
        {
            if($.trim(id) == '') return false;

            axios.delete('/post/'+id).then(function(data) {
                if(data.data['status'] == 1)
                {
                    $('#box_'+id).fadeOut(500);
                }
            });
        }
    </script>
@endsection