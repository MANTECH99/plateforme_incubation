<!-- app.blade.php dans layouts -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Plateforme incubation')</title>

    <!-- CSS global -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- CSS de Bootstrap -->




    @stack('styles')
</head>

<body>

    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div id="main-wrapper">
         <!-- Header Section -->
         @include('partials.header')

<!-- Sidebar Section -->
@include('partials.sidebar')

<!-- Main Content -->
<div class="content-body">
    <div class="container-fluid mt-3">
        @yield('content')
    </div>
</div>

<!-- Footer Section -->
@include('partials.footer')

</div>

<!-- JS Scripts -->
<script src="{{ asset('plugins/common/common.min.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>

    <script>
    window.routes = {
        messagesInbox: "{{ route('messages.inbox') }}",
    };
    window.userIsAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
</script>

    @stack('scripts')
@vite('resources/js/app.js')
@vite('resources/js/mentorship_calendar.js')

</body>
</html>