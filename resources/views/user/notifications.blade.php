@extends('layout')

@section('page-title', 'پیام های دریافت شده کاربر')
@section('meta-desc', 'پیام های دریافت شده کاربر')
@section('meta-keyword', 'پیام های دریافت شده کاربر')

@section('content')
    @include('user.user-navbar')
    <div class="col-8">
    <div class="card text-right">
        <div class="card-title m-3">
            پیام ها
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>پیام</th>
                        <th>خوانده شده</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($notifications as $notification)
                    <tr id="box_{{$notification->id}}">
                        <td>{{$notification->id}}</td>
                        <td>{{$notification->message}}</td>
                        <td>@if($notification->read) <i class="fa fa-check" aria-hidden="true"></i> @else <i class="fa fa-times" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm clearfix" href="javascript:void(0)" onclick="if(confirm('برای حذف این آیتم مطمئن هستید؟'))
                                    {
                                    removeOne({{$notification->id}})
                                    }">
                                <i class="fa fa-trash-o fa-lg"></i> حذف </a>
                            <a class="btn btn-primary btn-sm" href="{{route('user.readNotification', $notification->id)}}">
                                @if($notification->read == 0) <i class="fa fa-cog"></i> فعال کردن پست </a>
                            @else <i class="fa fa-cog"></i> غیر فعال کردن پست </a>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- pagination -->
        <div class="col-12">
            {{$notifications->render()}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function removeOne(id)
        {
            if($.trim(id) == '') return false;

            axios.delete('/users/notifications/'+id).then(function(data) {
                if(data.data['status'] == 1)
                {
                    $('#box_'+id).fadeOut(500);
                }
            });
        }
    </script>
@endsection