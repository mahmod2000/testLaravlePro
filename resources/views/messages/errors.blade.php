@if($errors->count())
    @foreach($errors->all() as $error)
       <div class="p-3 mb-2 bg-danger text-white">
           {{$error}}
       </div>
    @endforeach
@endif