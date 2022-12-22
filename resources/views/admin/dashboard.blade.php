<x-master title="Dashboard">
    @section('style')
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    @endsection
    <div class="container">
        <div class="row col-xs-12">
            <div class="col-xl-8">
                <!--begin::Forms Widget 1-->
                <div class="card card-custom card-shadowless gutter-b card-stretch card-shadowless p-0">
                    <!--begin::Nav Tabs-->
                    <ul class="dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0" role="tablist">
                        <!--begin::Item-->
                        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                            <a class="nav-link active border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                               data-toggle="pill" href="#forms_widget_tab_1">
                                <span class="nav-icon py-2 w-auto">
                                    {{ getSVG('assets/media/svg/icons/Home/Library.svg', 'svg-icon-3x') }}
                                </span>
                                <span
                                    class="nav-text font-size-lg py-2 font-weight-bold text-center">{{ __('admin.sales_dashboard') }}</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                               data-toggle="pill" href="#forms_widget_tab_2">
                                <span class="nav-icon py-2 w-auto">
                                    {{ getSVG('assets/media/svg/icons/Media/Equalizer.svg', 'svg-icon-3x') }}
                                </span>
                                <span
                                    class="nav-text font-size-lg py-2 font-weight-bolder text-center">{{ __('admin.business_chars') }}</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                               data-toggle="pill" href="#forms_widget_tab_3">
                                <span class="nav-icon py-2 w-auto">
                                    {{ getSVG('assets/media/svg/icons/Clothes/T-Shirt.svg', 'svg-icon-3x') }}
                                </span>
                                <span
                                    class="nav-text font-size-lg py-2 font-weight-bolder text-center">{{ __('admin.most_sell_products') }}</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"
                               data-toggle="pill" href="#forms_widget_tab_4">
                                <span class="nav-icon py-2 w-auto">
                                    {{ getSVG('assets/media/svg/icons/Communication/Group.svg', 'svg-icon-3x') }}
                                </span>
                                <span
                                    class="nav-text font-size-lg py-2 font-weight-bolder text-center">{{ __('admin.best_customers') }}</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->

                        <!--end::Item-->
                        <!--begin::Item-->

                        <!--end::Item-->
                    </ul>
                    <!--end::Nav Tabs-->
                </div>
                <!--end::Forms Widget 1-->
            </div>
            <div class="col-xl-4">
                <!--begin::Engage Widget 8-->

                <!--end::Engage Widget 8-->
            </div>
        </div>
        <!--begin::Nav Content-->
        {{--        <div class="tab-content m-0 p-0">--}}
        {{--            <div class="tab-pane active" id="forms_widget_tab_1" role="tabpanel">--}}
        {{--                <div class="col-12 row">--}}
        {{--                    <div class="card card-custom card-stretch gutter-b" style="width: 100%">--}}
        {{--                        <div class="card-body d-flex p-0">--}}
        {{--                            <div class="flex-grow-1 p-12 card-rounded bgi-no-repeat d-flex flex-column justify-content-center align-items-center">--}}
        {{--                                <div class="row">--}}
        {{--                                    <div class="col-md-3">--}}
        {{--                                        <div class="col bg-white px-8 rounded-xl mr-7">--}}
        {{--                                            <div class="symbol symbol-45 symbol-light-warning mr-2 flex-shrink-0">--}}
        {{--                                                <div class="symbol-label">--}}
        {{--                                                    <span class="svg-icon svg-icon-lg svg-icon-warning">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Shopping/Dollar.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                            <a href="{{ route('admin.orders.index') }}" data-container="body"  data-content="{{ __('admin.check_orders') }}" data-toggle="popover" data-placement="top"  class="text-warning font-weight-bold font-size-h6">{{ __('order.overall_orders') }}</a>--}}
        {{--                                            <div style="padding-left: 60px">--}}
        {{--                                                <div class="d-flex">--}}
        {{--                                                    <span class="svg-icon svg-icon-md svg-icon-black flex-shrink-0 mr-3">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                    <span class="text-black">{{ $data->totalOrder }}</span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="col-md-3">--}}
        {{--                                        <div class="col bg-white px-8 rounded-xl">--}}
        {{--                                            <div class="symbol symbol-45 symbol-light-primary mr-4 flex-shrink-0">--}}
        {{--                                                <div class="symbol-label">--}}
        {{--                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Shopping/Wallet2.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                            <a href="#" class="text-primary font-weight-bold font-size-h6 mt-2"> {{ __('order.today_sales') }}</a>--}}
        {{--                                            <div class="mp-3" style="padding-left: 60px">--}}
        {{--                                                <div class="d-flex mb-1">--}}
        {{--                                                    <span class="svg-icon svg-icon-md svg-icon-black flex-shrink-0 mr-3">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                    <span class="text-black">{{ $data->todayOrder }}</span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="col-md-3">--}}
        {{--                                        <div class="col bg-white px-8 rounded-xl mr-7">--}}
        {{--                                            <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0">--}}
        {{--                                                <div class="symbol-label">--}}
        {{--                                                    <span class="svg-icon svg-icon-lg svg-icon-success">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Shopping/Chart-pie.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                            <a href="#" class="text-success font-weight-bold font-size-h6"> {{ __('order.month_sales') }}</a>--}}
        {{--                                            <div class="mp-3" style="padding-left: 60px">--}}
        {{--                                                <div class="d-flex mb-1">--}}
        {{--                                                    <span class="svg-icon svg-icon-md svg-icon-black flex-shrink-0 mr-3">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                    <span class="text-black">{{ $data->monthOrder }}</span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="col-md-3">--}}
        {{--                                        <div class="col bg-white px-8 rounded-xl">--}}
        {{--                                            <div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">--}}
        {{--                                                <div class="symbol-label">--}}
        {{--                                                    <span class="svg-icon svg-icon-lg svg-icon-info">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Shopping/Chart-line1.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                            <a href="#" class="text-info font-weight-bold font-size-h6 mt-2">{{ __('order.year_sales') }}</a>--}}
        {{--                                            <div class="mp-3" style="padding-left: 60px">--}}
        {{--                                                <div class="d-flex mb-1">--}}
        {{--                                                    <span class="svg-icon svg-icon-md svg-icon-black flex-shrink-0 mr-3">--}}
        {{--                                                        {{ getSVG('assets/media/svg/icons/Navigation/Arrow-right.svg') }}--}}
        {{--                                                    </span>--}}
        {{--                                                    <span class="text-black">{{ $data->yearOrder }}</span>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        <div class="col-12 align-items-center row">
            {{-- <div class="col-6">
                <div id="chart_2"></div>
            </div> --}}
            <div class="col-6">
                <div id="chart_1"></div>
            </div>
            <div class="col-6">
                <div id="chart_4"></div>
            </div>
        </div>
        <br>
        <br>
        <hr>
        <div class="col-12 align-items-center row">

            <div class="col-6">

                <div id="chart_6"></div>
            </div>
            <div class="col-6">

                <div id="chart_8"></div>
            </div>
        </div>




        {{--                    <div class="col-6">--}}
        {{--                        <div class="card card-custom gutter-b">--}}
        {{--                            <div class="card-body">--}}
        {{--                                <h3>--}}
        {{--                                    {{ __('order.recent_order') }}--}}
        {{--                                </h3>--}}
        {{--                                <!--begin: Datatable-->--}}
        {{--                                <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable" data-locale="{{getCurrentLanguageSymbol()}}"></div>--}}
        {{--                                <!--end: Datatable-->--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
    </div>
    </div>
    {{--            <div class="tab-pane" id="forms_widget_tab_2" role="tabpanel">--}}
    {{--                <div class="col-12 row">--}}
    {{--                    <div class="col-6">--}}
    {{--                        <!--begin::Card-->--}}
    {{--                        <div class="card card-custom gutter-b">--}}
    {{--                            <div class="card-header">--}}
    {{--                                <div class="card-title">--}}
    {{--                                    <h3 class="card-label">{{__('admin.users_customers')}}</h3>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="card-body">--}}
    {{--                                <!--begin::Chart-->--}}
    {{--                                <div id="chart_11" class="d-flex justify-content-center"></div>--}}
    {{--                                <!--end::Chart-->--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <!--end::Card-->--}}
    {{--                    </div>--}}
    {{--                    <div class="col-6">--}}
    {{--                        <div class="card card-custom gutter-b">--}}
    {{--                            <div class="card-body">--}}
    {{--                                <h3>--}}
    {{--                                    {{ __('admin.best_customers') }}--}}
    {{--                                </h3>--}}
    {{--                                <!--begin: Datatable-->--}}
    {{--                                <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_customers" data-locale="{{getCurrentLanguageSymbol()}}"></div>--}}
    {{--                                <!--end: Datatable-->--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="tab-pane" id="forms_widget_tab_3" role="tabpanel">--}}

    {{--            </div>--}}
    {{--            <div class="tab-pane" id="forms_widget_tab_4" role="tabpanel">--}}

    {{--            </div>--}}
    {{--            <div class="tab-pane" id="forms_widget_tab_5" role="tabpanel">--}}
    {{--                System Security--}}
    {{--            </div>--}}
    {{--            <div class="tab-pane" id="forms_widget_tab_6" role="tabpanel">--}}
    {{--                Important Reports--}}
    {{--            </div>--}}
    {{--        </div>--}}
    </div>
    @section('scripts')
        @if(auth()->user()->hasRole('Admin'))
            <script src="{{ asset('js/dashboard.js') }}"></script>
        @elseif(auth()->user()->hasRole('vendor'))
            <script src="{{ asset('js/vendor-dashboard.js') }}"></script>
        @endif
    @endsection
</x-master>
