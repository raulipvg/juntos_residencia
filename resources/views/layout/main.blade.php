<!DOCTYPE html>
<html lang="es">
	<!--begin::Head-->
	<head><base href=""/>
		<title>Informes Campus Abierto</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:locale" content="es_US" />
		<meta property="og:type" content="article" />
		<meta property="og:site_name" content="Campus Abierto" />
		<link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
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
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">

		@include('layout.header')	
        
        @yield('main-content')
        
        @include('layout.footer')

		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('js/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->

       
    
        @stack('Script')
	
	</body>
	<!--end::Body-->
</html>

