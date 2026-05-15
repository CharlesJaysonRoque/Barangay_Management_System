@extends('index')

@section('content')
<div class="flex flex-col md:flex-row">


    <div class="container p-6">
        @yield('adminContent')
    </div>

</div>
@endsection
