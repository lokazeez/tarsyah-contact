<!--begin::Advance Table Widget 3-->
<div class="card card-custom gutter-b shadow-lg mt-10">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">{{ __('admin.all_'.plural($item)) }}</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-0 pb-3">
        <!--begin::Table-->
        <table class="table  table-head-custom table-head-bg table-borderless table-vertical-center">
            <tbody>
            @include('admin.'.$item.'._gridFilter')
            <div class="datatable datatable-bordered datatable-head-custom"
                 id="kt_datatable" data-locale="{{app()->getLocale()}}" data-url="{{ route('admin.datatables.getContacts') }}">
            </div>
            </tbody>
        </table>
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 3-->
