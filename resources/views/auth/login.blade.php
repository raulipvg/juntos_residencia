@extends('layout.auth')

@section('main-content')
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; 
var themeMode; 
if ( document.documentElement ) 
{ if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
    themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
} else { 
    if ( localStorage.getItem("data-bs-theme") !== null ) { 
        themeMode = localStorage.getItem("data-bs-theme"); 
    } else { 
        themeMode = defaultThemeMode; 
        } } 
        if (themeMode === "system") { 
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10">
                    <!--begin::Form-->
                    <form id="Formulario-login" action="" method="POST" class="form w-100" >
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">Iniciar Sesión</h1>
                            <!--end::Title-->
                            <!--begin::Subtitle-->
                            <div class="text-gray-500 fw-semibold fs-6">Juntos Residencia</div>
                            <!--end::Subtitle=-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Login options-->
								<div class="row g-3 mb-9">
									<!--begin::Col-->
									<div class="col-md-6">
										<!--begin::Google link=-->
										<a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
										<img alt="Logo" src="{{asset('/img/google-icon.svg')}}" class="h-15px me-3" />Sign in with Google</a>
										<!--end::Google link=-->
									</div>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-md-6">
										<!--begin::Google link=-->
										<a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
										<img alt="Logo" src="{{asset('/img/apple-black.svg')}}" class="theme-light-show h-15px me-3" />
										<img alt="Logo" src="{{asset('/img/apple-black-dark.svg')}}" class="theme-dark-show h-15px me-3" />Sign in with Apple</a>
										<!--end::Google link=-->
									</div>
									<!--end::Col-->
								</div>
								<!--end::Login options-->
                        <!--begin::Separator-->
                        <div class="separator separator-content my-14">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">Bienvenido</span>
                        </div>
                        <!--end::Separator-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Username-->
                            <input type="text" placeholder="Username" name="Username" class="form-control bg-transparent" id="InputUsername"/>
                            <!--end::Username-->
                        </div>
                        <!--end::Input group=-->
                        <div class="fv-row mb-3">
                            <!--begin::Password-->
                            <input type="password" placeholder="Contraseña" name="password" id="InputPassword" class="form-control bg-transparent" />
                            <!--end::Password-->
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div></div>
                        </div>
                        <!--end::Wrapper-->
                        <div id="AlertaError" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                        </div>
                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="button" class="btn btn-primary" name="login" id="login" data-kt-indicator="off">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Iniciar Sesion</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Cargando...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->
        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url('{{ asset('media/auth/auth-bg.png') }}')">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <!--begin::Logo-->
                <a href="../../demo6/dist/index.html" class="mb-0 mb-lg-12">
                    <img alt="Logo" src="{{ asset('img/JRlogo.svg')}}" class="h-140px h-lg-150px" />
                </a>
                <!--end::Logo-->
                <!--begin::Image-->
                <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-10" src="{{ asset('img/1.png')}}" alt="" style="border-radius: 10px;"/>
                <!--end::Image-->
               <!--begin::Title-->
						<h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                            Rápida, eficiente y productiva</h1>
						<!--end::Title-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Aside-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
@endsection

@push('Script')
<script>
    const login = "{{ route('login.attempt') }}";
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

<script src="{{ asset('js/eventos/login.js?id=4') }}"></script>
@endpush