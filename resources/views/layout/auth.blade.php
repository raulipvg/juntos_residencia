<!DOCTYPE html>
<html lang="es">
	<!--begin::Head-->
	<head><base href=""/>
		<title>Juntos Residencia</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:locale" content="es_US" />
		<meta property="og:type" content="article" />
		<meta property="og:site_name" content="Campus Abierto" />
		<link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('css/plugins.bundle.css?id=6') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/style.bundle.css?id=7') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->   

		<!-- begin::CSS de Pagina -->
        @stack('css')
		<!-- end::CSS de Pagina -->
		
        
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg">

        
        @yield('main-content')


		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('js/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('js/passive_events.js') }}"></script>
		<!--end::Global Javascript Bundle-->

       
    
        @stack('Script')

		@stack('Script2')
	
	</body>
	<!--end::Body-->
</html>

