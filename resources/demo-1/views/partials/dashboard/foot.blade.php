<script>
    let imagesBasePath  = "{{ asset('/storage/Images') }}";
    let currency        = " {{ __( settings()->get('currency') ) }} ";
    let locale          = "{{ getLocale() }}";
    let soundStatus = '{{ settings()->get('sound_status') }}';
    let notificationSoundOn = {{ settings()->get('notification_status') ?? 0 }};
</script>
<script src="{{asset('dashboard-assets/demo-1/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('dashboard-assets/demo-1/js/scripts.bundle.js')}}"></script>
<script src="{{asset('dashboard-assets/demo-1/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>
<script src="{{asset('js/translations.js')}}"></script>
<script src="{{asset('js/global_scripts.js')}}"></script>
<script src="{{asset('js/global_scripts.js')}}"></script>
@stack('scripts')
