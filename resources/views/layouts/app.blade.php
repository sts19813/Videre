<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Videre')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Metronic CSS --}}
    <link href="{{ asset('metronic/assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('metronic/assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('metronic/assets/css/styles.css') }}" rel="stylesheet" />

    @stack('styles')
</head>

<body class="antialiased flex h-full bg-background">

<script>
    const defaultThemeMode = 'light';
    let themeMode = localStorage.getItem('kt-theme') ?? defaultThemeMode;
    document.documentElement.classList.add(themeMode);
</script>

<div class="flex grow flex-col">

    @include('partials.header')
    @include('partials.navbar')
    @include('partials.toolbar')

    {{-- APP CONTENT (METRONIC CORE) --}}
    <div class="app-content flex-grow">
        <div class="kt-container-fixed py-6">
            @yield('content')
        </div>
    </div>

    @include('partials.footer')
</div>

@include('partials.scripts')
@stack('scripts')

</body>
</html>
