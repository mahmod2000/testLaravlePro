@extends('layout')

@section('content')
    @include('user.user-navbar')
    <div class="col-8 p3">
    <div class="card">
        <div class="card-title p-3"> <h2>لیست پست های کاربر</h2> </div>

        @include('messages.message')

        <div class="card-body">
            <div class="p-3"> <a class="btn btn-danger" href="javascript:void(0)" onclick="destroyAll()">
                <i class="fa fa-trash-o fa-lg"></i> حذف موارد انتخاب شده </a>
                @if(auth()->user()->hasRole('superadministrator|post-author|post-admin')) <a href="{{route('post.create')}}" class="btn btn-primary">ایجاد پست جدید</a> @endif
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>تاریخ ایجاد</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr id="box_{{$post->id}}">
                        <td><label class="label"> <input type="checkbox" class="remove_checkbox" id="checkbox_{{$post->id}}" value="{{$post->id}}"> {{$post->id}} </label></td>
                        <td><a href="{{route('post.show', $post)}}"> {{$post->title}} </a></td>
                        <td>{{verta($post->created_at)->format('%B %d, %Y')}}</td>
                        <td>
                            @if(auth()->user()->hasRole('superadministrator|post-admin'))
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="if(confirm('برای حذف این آیتم مطمئن هستید؟'))
                            {
                                removeOne({{$post->id}})
                            }">
                                <i class="fa fa-trash-o fa-lg"></i> حذف </a>
                            @endif
                            @if(auth()->user()->hasRole('superadministrator|post-editor|post-admin'))
                            <a class="btn btn-primary btn-sm" href="{{route('post.edit', $post->id)}}">
                                <i class="fa fa-cog"></i> ویرایش </a>
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