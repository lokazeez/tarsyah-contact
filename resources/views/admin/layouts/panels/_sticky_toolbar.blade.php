<ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
    <!--begin::Item-->
    <li class="nav-item mb-2"  data-toggle="tooltip" title="{{ __('admin.go_to_website') }}" data-placement="right">
{{--        <a class="btn btn-sm btn-icon btn-bg-light btn-text-success btn-hover-success" href="{{ route('home') }}">--}}
            <i class="flaticon2-drop"></i>
        </a>
    </li>
    <!--end::Item-->
    @role('Admin')
    <!--begin::Item-->
    <li class="nav-item mb-2" data-toggle="tooltip" title="{{ __('admin.go_to_settings') }}" data-placement="left">
        <a class="btn btn-sm btn-icon btn-bg-light btn-text-primary btn-hover-primary" href="{{ route('admin.settings.index') }}">
            <i class="flaticon2-gear"></i>
        </a>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="nav-item mb-2" data-toggle="tooltip" title="{{ __('admin.connect_with_the_developer') }}" data-placement="left">
        <a class="btn btn-sm btn-icon btn-bg-light btn-text-warning btn-hover-warning" href="https://octopus.com" target="_blank">
            <i class="flaticon2-telegram-logo"></i>
        </a>
    </li>
    <!--end::Item-->
    @endrole

</ul>
