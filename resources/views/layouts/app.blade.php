<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Dashboard')</title>
  <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @stack('styles')
</head>

<body>
  <div class="container-scroller">
    @include('partials.header')

    <div class="container-fluid page-body-wrapper">
      @include('partials.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('partials.footer')
      </div>
    </div>
  </div>

  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('js/template.js') }}"></script>
  @stack('scripts')

    <script>
    window.routes = {
        messagesInbox: "{{ route('messages.inbox') }}",
    };
    window.userIsAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
</script>
@vite('resources/js/app.js')
@vite('resources/js/mentorship_calendar.js')

</body>
</html>
