@extends('layout.master')
@section('title', 'Home Page')
@section('content')
    <div class="container my-5">
        @if (Session::get('rememberMe') === 'on')
            <script>
                localStorage.setItem('rememberMe', true);
                localStorage.setItem('phone',"{{ Auth::user()->phone }}");
            </script>
        @else
            <script>
                localStorage.setItem('rememberMe', false);
                localStorage.removeItem('phone');
            </script>
        @endif
    </div>
@endsection
@section('foot')
    <script>

    </script>
@stop
