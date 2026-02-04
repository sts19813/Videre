<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Videre')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}

    {{-- Keenicons (Metronic icons solamente) --}}
    <link href="{{ asset('/metronic/assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet">

    	<!-- Vendor Stylesheets (para páginas específicas, opcional) -->
	<link href="{{ asset('/metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
		type="text/css" />
	<link href="{{ asset('/metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
		type="text/css" />

	<!-- Global Stylesheets Bundle (obligatorios) -->
	<link href="{{ asset('/metronic/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/metronic/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />


    @stack('styles')
</head>

<body class="bg-light">

    {{-- HEADER --}}
    @include('partials.header')

    {{-- NAVBAR / SIDEBAR --}}
    @include('partials.navbar')

    {{-- MAIN CONTENT --}}
    <main class="container-fluid">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    <!--begin::Javascript-->
	<script>
		var hostUrl = "{{ asset('assets') }}/";
	</script>

	<!--begin::Global Javascript Bundle (obligatorio para todas las páginas)-->
	<script src="{{ asset('/metronic/assets/plugins/global/plugins.bundle.js') }}"></script>
	<script src="{{ asset('/metronic/assets/js/scripts.bundle.js') }}"></script>
	<!--end::Global Javascript Bundle-->


    @stack('scripts')
</body>
</html>
