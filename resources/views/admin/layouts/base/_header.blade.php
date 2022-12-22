<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container d-flex align-items-stretch justify-content-between">
        <!--begin::Left-->
        <div class="d-none d-lg-flex align-items-center mr-3">
            <!--begin::Aside Toggle-->
            <button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
                    <span class="svg-icon svg-icon-xxl svg-icon-dark-75">
                        {{ getSVG('assets/media/svg/icons/Text/Align-left.svg') }}
                    </span>
            </button>
            <!--end::Aside Toggle-->
            <!--begin::Logo-->
            <a href="{{ route('admin.dashboard') }}">
                <img onerror="this.src='{{asset('assets/assets/images/no-image.jpg')}}';"  alt="Logo" src="{{asset('images/logo.png')}}" class="logo-sticky max-h-35px" />
            </a>
            <!--end::Logo-->
            <!--begin::Desktop Search-->
            <div class="quick-search quick-search-inline ml-20 w-300px" id="kt_quick_search_inline">
                <!--begin::Form-->
                <form method="get" class="quick-search-form">
                    <div class="input-group rounded bg-light">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="svg-icon svg-icon-lg">
                                    {{ getSVG('assets/media/svg/icons/General/Search.svg') }}
                                </span>
                            </span>
                        </div>
                        <input type="text" class="form-control h-45px" placeholder="Search..." />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="quick-search-close ki ki-close icon-sm text-muted"></i>
                            </span>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
                <!--begin::Search Toggle-->
                <div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,1px"></div>
                <!--end::Search Toggle-->
                <!--begin::Dropdown-->
                <div class="dropdown-menu dropdown-menu-left dropdown-menu-lg dropdown-menu-anim-up">
                    <div class="quick-search-wrapper scroll" data-scroll="true" data-height="350" data-mobile-height="200"></div>
                </div>
                <!--end::Dropdown-->
            </div>
            <!--end::Desktop Search-->
        </div>
        <!--end::Left-->
        <!--begin::Topbar-->
        @include('admin.layouts.base._topbar')
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
