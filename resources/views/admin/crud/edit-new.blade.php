<x-master title="{{__('admin.'.getAction() )}} {{ __('admin.'.$item) }}">

    <x-breadcrumb :item="$item"></x-breadcrumb>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">
                    <h1 class="mt-10" >{{ __('admin.'.getAction())}}  @if(isset(${$item}))<code>{{ ${$item}->name ?? ${$item}->title }} </code>@endif {{ __('admin.'.$item) }}</h1>

                    @include('admin.layouts.panels._alerts')
                    <x-form :action="getNextAction($item, ${$item} ?? null)" :entity="${$item} ?? null" :submit="getActionMethod()" :onelanguage="false"></x-form>
                    @if(View::exists('admin.'.$item.'._modal'))
                        @include('admin.'.$item.'._modal')
                    @endif
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

    <x-slot name="footer"></x-slot>
    @section('scripts')
        @include('admin.'.$item.'._scripts')
    @endsection
</x-master>
