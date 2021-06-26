<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    @auth
        <div style="background-color: #F8F7F7">
            @include('layout.navbar')

        </div>
    @endauth
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Sweat alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('share.flash_message')
    @stack('script')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if (session('login'))
            Toast.fire({
            icon: 'success',
            title: "{{ session('login') }}"
            })
        @endif
    </script>
</body>

</html>
