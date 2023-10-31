<!DOCTYPE html>
<html lang="{{ getLocale() }}" direction="{{ isArabic() ? 'ltr' : 'rtl' }}" style="direction:{{ app()->getLocale() == 'ar' ? 'ltr' : 'rtl' }}">
<!--begin::Head-->
<head>
    <title>Dashboard Setup</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="icon" href="#" type="image/gif" sizes="16x16">

    <!--begin::Fonts-->
    @if ( isArabic() )
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">
    @endif
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('dashboard-assets/demo-1/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{  asset('dashboard-assets/demo-1/css/style'  . '.bundle' . ( isArabic() ? '.rtl' : '' ) . '.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat bg-dark">
<!--begin::Theme mode setup on page load-->
<script>let defaultThemeMode = "light"; let themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>body { background-image: url('{{ asset('dashboard-assets/demo-1/media/auth/bg10.jpeg') }}'); } [data-theme="dark"] body { background-image: url({{ asset('dashboard-assets/demo-1/media/auth/bg10-dark.jpeg') }}'); }</style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                <!--begin::Image-->
                <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('dashboard-assets/demo-1/media/auth/agency.png') }}" alt="" />
                <!--end::Image-->
                <!--begin::Title-->
                <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">{{ __('Fast, Efficient and Productive') }}</h1>
                <!--end::Title-->
            </div>
            <!--end::Content-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10" >
                <!--begin::Content-->
                <div class="w-md-400px" style="direction:{{ isArabic() ? 'rtl' : 'ltr' }}" >
                    <!--begin::Form-->
                    <form class="form w-100 submitted-form"  data-success-message="{{ __("Signed in successfully") }}" data-redirection-url="{{ url()->previous() != request()->root() ?  url()->previous() : '/dashboard' }}" action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-muted my-8">{{ __('Dashboard') }}</h1>
                            <!--end::Title-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Email') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="text" name="email" id="email_inp" autocomplete="off" />
                            <p class="invalid-feedback" id="email"></p>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Password') }}</label>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <div class="d-flex align-items-center" >
                                <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" id="password_inp" />
                                <a onclick="showHidePass( 'password_inp' , $(this) )" style="cursor: pointer">
                                    <span class="fa fa-fw fa-eye fa-md toggle-password"  @if( isArabic() )  style="margin-right:-30px" @else style="margin-left:-30px" @endif></span>
                                </a>
                            </div>
                            <p class="invalid-feedback" id="password"></p>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Submit button-->

                            <button type="submit" id="submit-btn" class="btn btn-lg btn-primary w-100 mb-5" data-kt-indicator="">
                            <span class="indicator-label">
                                {{ __('Sign In') }}
                            </span>

                                <span class="indicator-progress">
                            {{ __('Please wait ...') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>

                            </button>
                            <!--end::Submit button-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->

                    <!--begin::Footer-->
                    <div class="d-flex flex-center flex-column-auto p-10">
                        <!--begin::Links-->
                        <div class="d-flex align-items-center fw-bold fs-6">
                            <a href="https://www.linkedin.com/in/hossam-ghoneim-794b061b7/" target="_blank" class="text-muted text-hover-primary px-2">
                                {{ __('Developed By') }}  <img class="mx-4" src="https://www.linkedin.com/in/hossam-ghoneim-794b061b7/"  >
                            </a>
                        </div>
                        <!--end::Links-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>
    let locale = "{{ getLocale() }}";
</script>
<script src="{{ asset('dashboard-assets/demo-1/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('dashboard-assets/demo-1/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('js/translations.js') }}"></script>
<script src="{{ asset('js/global_scripts.js') }}"></script>
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
