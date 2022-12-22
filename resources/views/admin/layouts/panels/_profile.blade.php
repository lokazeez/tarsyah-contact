<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">{{ __('admin.admin_profile') }}
            <small class="text-muted font-size-sm ml-2">{{ __('admin.logged_admin') }}</small></h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    @php $admin = auth()->user() @endphp
    <!--end::Header-->

    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image: url({{ $admin->avatar ? storageImage($admin->avatar) : asset('media/users/blank.png') }})"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ $admin->name }}</a>
                <div class="text-muted mt-1">{{ $admin->username }}</div>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
                        <span class="navi-link p-0 pb-2">
                            <span class="navi-icon mr-1">
                                <span class="svg-icon svg-icon-lg svg-icon-primary">
                                        {{ getSVG("assets/media/svg/icons/Communication/Mail-notification.svg", "svg-icon-lg") }}
                                </span>
                            </span>
                            <span class="navi-text text-muted text-hover-primary">{{ $admin->email }}</span>
                        </span>
                    </a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <input type="submit" value="{{ __('admin.logout') }}" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">
                    </form>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Separator-->
        <div class="separator separator-dashed mt-8 mb-5"></div>
        <!--end::Separator-->
        <!--begin::Nav-->
        <div class="navi navi-spacer-x-0 p-0">
            <!--begin::Item-->
            <a href="{{ route('admin.admins.edit', ['admin' => $admin]) }}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                            <span class="svg-icon svg-icon-md svg-icon-success">
                                {{ getSVG("assets/media/svg/icons/General/Notification2.svg", "svg-icon-xl") }}
                            </span>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">{{ __('admin.my_profile') }}</div>
                        <div class="text-muted">{{ __('admin.account_settings') }}
                            <span class="label label-light-danger label-inline font-weight-bold">{{ __('admin.update') }}</span></div>
                    </div>
                </div>
            </a>
            <!--end:Item-->
        </div>
        <!--end::Nav-->
        <!--begin::Separator-->
        <div class="separator separator-dashed my-7"></div>
        <!--end::Separator-->
    </div>
    <!--end::Content-->
</div>
