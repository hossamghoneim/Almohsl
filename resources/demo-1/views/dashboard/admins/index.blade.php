@extends('partials.dashboard.master')
@push('styles')
    <link href="{{ asset('dashboard-assets/demo-1/css/datatables' . ( isDarkMode() ?  '.dark' : '' ) .'.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{ __('قائمة الموظفين') }}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap mb-5">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="{{ __('ابحث عن الموظفين') }}">
                </div>
                <!--end::Search-->
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" id="add_btn" data-bs-toggle="modal" data-bs-target="#crud_modal" data-kt-docs-table-toolbar="base">
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-original-title="Coming Soon" data-kt-initialized="1">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>
                        <!--end::Svg Icon-->{{ __('إضافة موظف') }}</button>
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-docs-table-select="selected_count"></span>{{ __('عنصر محدد') }}</div>
                    <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">{{ __('حذف') }}</button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Datatable-->
            <table id="kt_datatable" class="table align-middle text-center table-row-dashed fs-6 gy-5">
                <thead>
                <tr class=" text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable .form-check-input" value="1"/>
                        </div>
                    </th>
                    <th>{{ __('الأسم') }}</th>
                    <th>{{ __('البريد الالكتروني') }}</th>
                    <th>{{ __('تاريخ الإنشاء') }}</th>
                    <th class=" min-w-100px">{{ __('الإجراءات') }}</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                </tbody>
            </table>
            <!--end::Datatable-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->

    {{-- begin::Add Country Modal --}}
    <form id="crud_form" class="ajax-form" action="{{ route('dashboard.admins.store') }}" method="post" data-success-callback="onAjaxSuccess" data-error-callback="onAjaxError">
        @csrf
        <div class="modal fade" tabindex="-1" id="crud_modal">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form_title">{{ __('إضافة موظف جديد') }}</h5>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="name_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('الإسم') }}</label>
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid" id="name_inp" placeholder="{{ __('إسم الموظف') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="name"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="email_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('البريد الإلكتروني') }}</label>
                            <input type="text" name="email" autocomplete="new-password" class="form-control form-control-lg form-control-solid" id="email_inp" placeholder="{{ __('البريد الإلكتروني للموظف') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="email"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="phone_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('رقم الهاتف') }}</label>
                            <input type="text" name="phone" class="form-control form-control-lg form-control-solid" id="phone_inp" placeholder="05xxxxxxxx" >
                            <div class="fv-plugins-message-container invalid-feedback" id="phone"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="roles_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('الصلاحيات') }}</label>
                            <select class="form-select form-select-solid" multiple="multiple" data-dir="rtl" name="roles[]" id="roles_inp" data-control="select2" data-placeholder="{{ __('اختر الصلاحيات') }}" data-allow-clear="true">
                                @foreach( $roles as $role)
                                    <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                @endforeach
                            </select>
                            <div class="fv-plugins-message-container invalid-feedback" id="roles"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="password_inp" class="form-label fs-6 fw-bold mb-3">{{ __('كلمة المرور') }}</label>
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3" data-kt-password-meter="true">
                                <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="new-password" id="password_inp" placeholder="{{ __('كلمة المرور') }}"  />
                                <!--begin::Visibility toggle-->
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                      data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>

                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                                <!--end::Visibility toggle-->
                            </div>
                            <!--end::Input wrapper-->
                            <div class="fv-plugins-message-container invalid-feedback" id="password"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="password_confirmation_inp" class="form-label fs-6 fw-bold mb-3">{{ __('تأكيد كلمة المرور') }}</label>
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3" data-kt-password-meter="true">
                                <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation" autocomplete="off" id="password_confirmation_inp" placeholder="{{ __('كلمة المرور') }}"  />
                                <!--begin::Visibility toggle-->
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                      data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>

                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                                <!--end::Visibility toggle-->
                            </div>
                            <!--end::Input wrapper-->
                            <div class="fv-plugins-message-container invalid-feedback" id="password_confirmation"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('اغلاق') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                {{ __('حفظ البيانات') }}
                            </span>
                            <span class="indicator-progress">
                                {{ __('يرجى الانتظار...') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- end::Add Country Modal --}}

@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard/global/datatable-config.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/admins.js') }}"></script>
    <script src="{{ asset('js/dashboard/crud-operations.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#add_btn").click(function (e) {
                e.preventDefault();

                $("#form_title").text(__('إضافة موظف جديد'));
                $("[name='_method']").remove();
                $("#crud_form").trigger('reset');
                $("#crud_form").attr('action', `/dashboard/admins`);
                $("[for*='password']").addClass('required')
            });


        });
    </script>
@endpush
