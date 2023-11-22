@extends('partials.dashboard.master')
@push('styles')
    <link href="{{ asset('dashboard-assets/demo-1/css/datatables' . ( isDarkMode() ?  '.dark' : '' ) .'.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Order details page-->
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <!--begin::Order summary-->
                <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                    <!--begin::Matched Data-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('Matched data') }}</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-sms fs-2 me-2"></i>{{ __('Car Number') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">
                                                <span class="text-gray-600 text-hover-primary">{{ $matchedCar->car_number }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Type') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Latitude') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->lat }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Longitude') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->lng }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('District') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->district }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Location') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->location }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Vehicle manufacturer') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->vehicle_manufacturer }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Vehicle model') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->vehicle_model }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Traffic structure') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->traffic_structure }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Source') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->source }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Color') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->color }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Model year') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->model_year }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Username') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->username }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Board registration type') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->board_registration_type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('User identity') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->user_identity }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Contract number') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->contract_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Cic') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->cic }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Certificate status') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->certificate_status }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Vehicles count') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->vehicles_count }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Product') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->product }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Installments count') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->installments_count }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Late days count') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->late_days_count }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('City') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->city }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-2 me-2"></i>{{ __('Employer') }}</div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $matchedCar->employer }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Vendor Details-->
                </div>
                <!--end::Order summary-->
            </div>
            <!--end::Order details page-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

@endsection
