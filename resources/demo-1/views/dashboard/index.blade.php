@extends('partials.dashboard.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar" >
        <!--begin::Container-->
        <div  class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __("Dashboard") }}

                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->

                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1"></small>
                <!--end::Description-->

            </h1>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <a href="/" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-globe fs-6"></i> {{ __("website") }} </a>
                <a href="#" target="_blank" class="btn btn-sm btn-success"><i class="bi bi-whatsapp fs-6"></i> {{ __("whatsapp") }} </a>
                <a href="#" target="_blank" class="btn btn-sm btn-dark"><i class="bi bi-envelope-fill fs-6"></i> {{ __("mail") }} </a>
                <!--end::Primary button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!-- end   :: Subheader -->

@endsection
