@extends('partials.dashboard.master')
@push('styles')
    <link href="{{ asset('dashboard-assets/demo-1/css/datatables' . ( isDarkMode() ?  '.dark' : '' ) .'.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard-assets/demo-1/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>

    <style>
        .headerIcons{
            font-size: 1.3rem;
        }

        .activeTab, .activeTab i{
            color: #0095E8;
            background-color: #f3f3f3 !important;
        }

        .activeTab, .activeTab p{
            color: #0095E8;
            background-color: #f3f3f3 !important;
        }

        .trashTab{
            color: white;
            background-color: #1E1E2D;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            cursor: pointer
        }

    </style>
@endpush
@section('content')

<div class="row justify-content-center">

    <div class="trashTab col card  text-center h2 py-5 mb-0" data-model="Admin" >
        <i class="fa fa-users headerIcons"></i>
        <p class="my-3">{{ __("Admins") }}</p>
    </div>


</div>

<!-- begin :: Datatable card -->
<div class="row card mb-2">
    <!-- begin :: Card Body -->
    <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">

            <div id="table-container">

            <!-- begin :: Datatable -->
            <table id="kt_datatable" class="table text-center table-row-dashed fs-6 gy-5">

                <thead>
                    <tr class="text-gray-400 fw-bolder fs-7 text-uppercase gs-0" id="table-header">
                        <th>#</th>
                        <th>{{ __("name") }}</th>
                        <th>{{ __("phone") }}</th>
                        <th>{{ __("email") }}</th>
                        <th>{{ __("created date") }}</th>
                        <th class="min-w-100px">{{ __("actions") }}</th>
                    </tr>
                </thead>

                <tbody class="text-gray-600 fw-bold text-center">

                </tbody>
            </table>
            <!-- end   :: Datatable -->

            </div>
    </div>
    <!-- end   :: Card Body -->
</div>
<!-- end   :: Datatable card -->

@endsection
@push('scripts')

    <script>
        let tabs          = $('.trashTab');
        let tableHeader   = $('thead tr').first();
        let modelName     = 'Admin';
        let datatable     = null;
        let userAbilities = @json( abilities() );
        let canDelete     = userAbilities.includes('delete_recycle_bin');
        let canRestore    = userAbilities.includes('restore_recycle_bin');

        // start map contains (html) table header columns
        let tableHeaderColumns = new Map();
        tableHeaderColumns.set('Admin', `
                    <th>#</th>
                    <th>{{ __("name") }}</th>
                    <th>{{ __("phone") }}</th>
                    <th>{{ __("email") }}</th>
                    <th>{{ __("created date") }}</th>
                    <th class="min-w-100px">{{ __("actions") }}</th>
        ` );
        // end map contains (html) table header columns

        // start map contains data table columns names
        let dataTableColumns = new Map();
        dataTableColumns.set('Admin', [
            {data: 'id'},
            {data: 'name'},
            {data: 'phone'},
            {data: 'email'},
            {data: 'created_at'},
            {data: null},
        ]);
        // end map contains data table columns names

        // start map contains data table columns definitions
        let dataTableColumnsDefs = new Map();
        dataTableColumnsDefs.set('Admin', [
            {
                targets: -1,
                data: null,
                render: function (data, type, row) {

                    return `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                ${translate('Actions')}
                                <span class="svg-icon svg-icon-5 m-0">
                                    <i class="fa fa-angle-down mx-1"></i>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

                            ${ canRestore ? `<!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3 d-flex justify-content-between restore-row" data-row-id="${row.id}" data-type="${translate('admin')}" >
                                        <span> ${translate('Restore')} </span>
                                        <span>  <i class="fas fa-share text-primary"></i> </span>
                                        </a>

                                    </div>
                                    <!--end::Menu item-->` : ``
                    }

                            ${ canDelete ? `<!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id}" data-type="${translate('admin')}">
                                    <span> ${translate('Delete')} </span>
                                    <span>  <i class="fa fa-trash text-danger"></i> </span>
                                    </a>
                                </div>
                            <!--end::Menu item-->` : ``

                    }

                            </div>
                            <!--end::Menu-->
                        `;

                },
            },
        ]);
        // end map contains data table columns definitions

        tabs.click(function(){

            tabs.removeClass('activeTab');

            $(this).addClass('activeTab');

            modelName = $(this).data('model');

            $('#table-container').html(`
                <table id="kt_datatable" class="table text-center table-row-dashed fs-6 gy-5">

                <thead>
                    <tr class="text-gray-400 fw-bolder fs-7 text-uppercase gs-0" id='table-header' >
                    ${ tableHeaderColumns.get(modelName) }
                    </tr>
                </thead>

                <tbody class="text-gray-600 fw-bold text-center">

                </tbody>
                </table>`
            );


            KTDatatable.init();

        })
    </script>
    <script src="{{ asset('js/dashboard/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/datatables/trash.js') }}"></script>

@endpush
