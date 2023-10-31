<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" direction="{{ isArabic() ? 'rtl' : 'ltr' }}" style="direction:{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-theme-mode="dark">
@include('partials.dashboard.head')
<!--begin::Body-->
<body  class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">

        <!-- begin :: Aside -->
    @include('partials.dashboard.aside')
    <!-- end   :: Aside -->

        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

            <!-- begin :: Header -->
        @include('partials.dashboard.header')
        <!-- end   :: Header -->

            <!-- begin :: Content -->
            <div class="content d-flex flex-column flex-column-fluid" >

                <div class="d-flex flex-column-fluid" >

                    <!-- begin :: Container -->
                    <div class="container-xxl">

                        @yield('content')

                    </div>
                    <!-- end   :: Container -->

                </div>

            </div>
            <!-- end   :: Content -->

            <!-- begin :: Footer -->
        @include('partials.dashboard.footer')
        <!-- end   :: Footer -->

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Root-->
<!--end::Main-->


<!-- begin :: Global Scroll top -->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
				</svg>
			</span>
    <!--end::Svg Icon-->
</div>
<!-- end   :: Global Scroll top -->

<!--begin::Toast-->
<div class="position-fixed bottom-0 sart-0 p-3 " style="z-index: 1090">
    <div id="kt_docs_toast_toggle" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="{{ getImagePathFromDirectory(settings()->get('favicon'), "Settings") }}" class="me-2 theme-light-show"  width="20" srcset="">
            <img src="{{ getImagePathFromDirectory(settings()->get('favicon'), "Settings") }}" class="me-2 theme-dark-show"  width="20" srcset="">
            <strong class="me-auto">{{ settings()->get('website_name_' . app()->getLocale()) }}</strong>
            <small>{{ __('الأن') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ __('.تمت العملية بنجاح') }}.
        </div>
    </div>
</div>
<!-- end::Toast -->

<audio controls id="notification-sound" style="display: none">
    <source class="sound-source" src="{{asset('dashboard-assets/sounds/new-notification.mp3')}}" type="audio/ogg">
    <source class="sound-source" src="{{asset('dashboard-assets/sounds/new-notification.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<audio controls id="success-sound" style="display: none">
    <source class="sound-source" src="{{asset('dashboard-assets/sounds/success.mp3')}}" type="audio/ogg">
    <source class="sound-source" src="{{asset('dashboard-assets/sounds/success.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<audio controls id="error-sound" style="display: none">
    <source class="sound-source" src="{{asset('dashboard-assets/sounds/error.mp3')}}" type="audio/ogg">
    <source class="sound-source" src="{{asset('dashboard-assets/sounds/error.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>


<!-- begin :: Global Javascript -->
@include('partials.dashboard.foot')
<!-- end   :: Global Javascript -->


</body>
<!--end::Body-->
</html>
