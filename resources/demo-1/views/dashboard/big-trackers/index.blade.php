@extends('partials.dashboard.master')
@section('content')
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{ __('Data List') }}</h3>
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
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="{{ __('Search for data') }}">
                    <select class="form-select form-select-solid w-200px ps-15 filter-input ms-2" data-filter-index="1" data-dir="@if(isArabic()) rtl @else ltr @endif" name="car_number_id" id="car_number_id_inp"
                        data-control="select2" data-allow-clear="true" data-placeholder="{{ __('اختر رقم اللوحة') }}">
                        <option></option>
                        @foreach ($carNumbers as $carNumber)
                            <option value="{{ $carNumber->id }}">{{ $carNumber->number }}</option>
                        @endforeach
                    </select>
                </div>
                <!--end::Search-->
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" id="add_btn" data-bs-toggle="modal" data-bs-target="#crud_modal" data-kt-docs-table-toolbar="base">
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-primary" id="upload_btn" data-bs-toggle="modal" data-bs-target="#kt_modal_upload">
                    <!--begin::Svg Icon | path: icons/duotune/files/fil018.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black" />
                                <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="white" />
                                <path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        {{ __('Upload File') }}
                    </button>
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-docs-table-select="selected_count"></span>{{ __('Selected items') }}</div>
                    <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">{{ __('Delete') }}</button>
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
                    <th>{{ __('Car Number') }}</th>
                    <th>{{ __('Username') }}</th>
                    <th>{{ __('User Identity') }}</th>
                    <th>{{ __('Cic') }}</th>
                    <th>{{ __('date') }}</th>
                    <th class=" min-w-100px">{{ __('actions') }}</th>
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

    <form id="crud_form" class="ajax-form" action="#" method="post" data-success-callback="onAjaxSuccess" data-error-callback="onAjaxError">
        @csrf
        <div class="modal fade" tabindex="-1" id="crud_modal">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form_title">{{ __('add new data') }}</h5>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="car_number_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Car Number') }}</label>
                            <input type="text" name="car_number" class="form-control form-control-lg form-control-solid" id="car_number_inp" placeholder="{{ __('Car Number') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="car_number"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="source_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Source') }}</label>
                            <input type="text" name="source" class="form-control form-control-lg form-control-solid" id="source_inp" placeholder="{{ __('Car Number') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="source"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="vehicle_manufacturer_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Vehicle manufacturer') }}</label>
                            <input type="text" name="vehicle_manufacturer" class="form-control form-control-lg form-control-solid" id="vehicle_manufacturer_inp" placeholder="{{ __('Vehicle Manufacturer') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="vehicle_manufacturer"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="vehicle_model_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Vehicle model') }}</label>
                            <input type="text" name="vehicle_model" class="form-control form-control-lg form-control-solid" id="vehicle_model_inp" placeholder="{{ __('Vehicle model') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="vehicle_model"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="traffic_structure_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Traffic structure') }}</label>
                            <input type="text" name="traffic_structure" class="form-control form-control-lg form-control-solid" id="traffic_structure_inp" placeholder="{{ __('Traffic Structure') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="traffic_structure"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="color_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Color') }}</label>
                            <input type="text" name="color" class="form-control form-control-lg form-control-solid" id="color_inp" placeholder="{{ __('Color') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="color"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="model_year_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Model year') }}</label>
                            <input type="text" name="model_year" class="form-control form-control-lg form-control-solid" id="model_year_inp" placeholder="{{ __('Model Year') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="model_year"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="username_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Username') }}</label>
                            <input type="text" name="username" class="form-control form-control-lg form-control-solid" id="username_inp" placeholder="{{ __('Username') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="username"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="board_registration_type_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Board registration type') }}</label>
                            <input type="text" name="board_registration_type" class="form-control form-control-lg form-control-solid" id="board_registration_type_inp" placeholder="{{ __('Board Registration Type') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="board_registration_type"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="user_identity_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('User identity') }}</label>
                            <input type="text" name="user_identity" class="form-control form-control-lg form-control-solid" id="user_identity_inp" placeholder="{{ __('User Identity') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="user_identity"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="contract_number_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Contract number') }}</label>
                            <input type="text" name="contract_number" class="form-control form-control-lg form-control-solid" id="contract_number_inp" placeholder="{{ __('Contract Number') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="contract_number"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="cic_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Cic') }}</label>
                            <input type="text" name="cic" class="form-control form-control-lg form-control-solid" id="cic_inp" placeholder="{{ __('Cic') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="cic"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="certificate_status_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Certificate status') }}</label>
                            <input type="text" name="certificate_status" class="form-control form-control-lg form-control-solid" id="certificate_status_inp" placeholder="{{ __('Certificate Status') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="certificate_status"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="vehicles_count_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Vehicles count') }}</label>
                            <input type="number" name="vehicles_count" class="form-control form-control-lg form-control-solid" id="vehicles_count_inp" placeholder="{{ __('Vehicles Count') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="vehicles_count"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="product_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Product') }}</label>
                            <input type="number" name="product" class="form-control form-control-lg form-control-solid" id="product_inp" placeholder="{{ __('Product') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="product"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="installments_count_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Installments count') }}</label>
                            <input type="number" name="installments_count" class="form-control form-control-lg form-control-solid" id="installments_count_inp" placeholder="{{ __('Installments Count') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="installments_count"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="late_days_count_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Late days count') }}</label>
                            <input type="number" name="late_days_count" class="form-control form-control-lg form-control-solid" id="late_days_count_inp" placeholder="{{ __('Late Days Count') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="late_days_count"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="city_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('City') }}</label>
                            <input type="text" name="city" class="form-control form-control-lg form-control-solid" id="city_inp" placeholder="{{ __('City') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="city"></div>
                        </div>
                        <div class="fv-row mb-0 fv-plugins-icon-container">
                            <label for="employer_inp" class="form-label required fs-6 fw-bold mb-3">{{ __('Employer') }}</label>
                            <input type="text" name="employer" class="form-control form-control-lg form-control-solid" id="employer_inp" placeholder="{{ __('Employer') }}" >
                            <div class="fv-plugins-message-container invalid-feedback" id="employer"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                {{ __('Save') }}
                            </span>
                            <span class="indicator-progress">
                                {{ __('Please wait ...') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--begin::Modal - Upload File-->
    <form id="upload_form" class="ajax-form" action="{{ route('dashboard.upload-big-file') }}" method="post" data-success-callback="onAjaxSuccess" data-error-callback="onAjaxError" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="kt_modal_upload" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder">{{ __('Upload File') }}</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body pt-10 pb-15 px-lg-17">
                        <!--begin::Input group-->
                        <div class="form-group">
                            <input type="file" name="file" id="file_inp">

                            <div class="fv-plugins-message-container invalid-feedback" id="excel_error"></div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Modal body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="indicator-label">
                                {{ __('Upload') }}
                            </span>
                            <span class="indicator-progress">
                                {{ __('Please wait ...') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Modal - Upload File-->

@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard/global/datatable-config.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/big-trackers.js') }}"></script>
    <script src="{{ asset('js/dashboard/crud-operations.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#upload_btn").click(function (e) {
                e.preventDefault();

                $("#upload_form").trigger('reset');
                $("#upload_form").attr('action', `/dashboard/upload-big-file`);
            });
        });
    </script>
@endpush
