@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
@endpush

<!--begin::Toolbar-->
<div class="toolbar py-2" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
        <!--begin::Page title-->
        <div class="flex-grow-1 flex-shrink-0 me-5">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Home
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-semibold my-1 ms-1">#XRS-45670</small>
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap" style="width: 200px;" >
            <!--begin::Wrapper-->
            <select id="ComunidadInput" name="Comunidad" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false">
                        <option></option>
                        @foreach($comunidades as $comunidad)                          
                        <option @if($comunidadId == $comunidad->Id) selected  @endif value="{{ $comunidad->Id }}">{{ Str::title($comunidad->Nombre)  }}</option>
                        @endforeach
                    </select>
           
            <!--end::Wrapper-->
        </div>
        <!--end::Action group-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">
    HOME
    
</div>
<!--end::Content-->


@endsection

@push('Script')
    <script>
      
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    </script>
 
    
@endpush