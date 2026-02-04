<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Videre')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Metronic CSS --}}
    <link href="{{ asset('metronic/assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('metronic/assets/assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('metronic/assets/css/styles.css') }}" rel="stylesheet" />

    @stack('styles')
</head>

<body
    class="antialiased flex h-full text-base text-foreground bg-background [--header-height:100px] data-[kt-sticky-header=on]:[--header-height:60px]">
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (
                document.documentElement.hasAttribute('data-kt-theme-mode')
            ) {
                themeMode =
                    document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>

    <div class="flex grow flex-col in-data-[kt-sticky-header=on]:pt-(--header-height)">

        @include('partials.header')

        @include('partials.navbar')

        @include('partials.toolbar')


        <!-- Content -->
        <main class="grow" id="content" role="content">
            <!-- Container -->
            <div class="kt-container-fixed" id="contentContainer">
            </div>
            <!-- End of Container -->

            @yield('content')

        </main>

        @include('partials.footer')


    </div>


    @include('partials.scripts')
    @stack('scripts')
</body>

</html>