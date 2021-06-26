@extends('layout.master')
@section('title', 'Login')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-12">
                <div class="card shadow rounded">
                    <div class="card-header bg-primary text-white">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST">
                            @csrf
                           <x-input name='phone' type='number' value="09777758089" />
                           <x-input name='password' type='password'/>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="rememberMe" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <button class="btn btn-primary mt-3">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot')
    <script>

    </script>
@stop
