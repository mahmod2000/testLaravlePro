@if(session()->has('success-message'))
    <div class="p-3 mb-2 bg-success text-white show-message"> {{session('success-message')}} </div>
@endif

@if(session()->has('error-message'))
    <div class="p-3 mb-2 bg-error text-white show-message"> {{session('error-message')}} </div>
@endif

@if(session()->has('danger-message'))
    <div class="p-3 mb-2 bg-danger text-white show-message"> {{session('danger-message')}} </div>
@endif