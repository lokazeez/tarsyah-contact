<x-master title="{{__('admin.show')}} {{ __('admin.'.$item) }}">

    <x-breadcrumb :item="$item"></x-breadcrumb>
    <x-slot name="richTextBoxScript"></x-slot>
    <!--begin::Container-->
    <div class="container">
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-xl-12">
                <h1 class="mt-10">{{ __('admin.show') }}
                    {{--					<code>{{ ${$item}->username?${$item}->username:${$item}->user->first_name }}</code> {{ __('admin.'.$item) }}--}}
                </h1>
                @include('admin.layouts.panels._alerts')
                <div class="card card-custom shadow-lg mt-10">
                    <div class="card card-custom gutter-b">
                        <div class="card-body px-0">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">{{ __($item.'.contact_details') }}</h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <ul class="nav nav-light-success nav-bold nav-pills">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_4_1">
                                                    <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                                    <span
                                                        class="nav-text">{{ ${$item}->created_at->format('Y M D H:II') ??  __('admin.empty') }}</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="kt_tab_pane_4_1" role="tabpanel"
                                             aria-labelledby="kt_tab_pane_4_1">
                                            <div class="card-body pt-3 pb-0">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div
                                                            class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#"
                                                                   class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.name') }}
                                                                </a>
                                                                <span
                                                                    class="text-muted font-weight-bold">{{${$item}->name}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div
                                                            class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="tel:{{${$item}->phone_number}}"
                                                                   class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.phone_number') }}
                                                                </a>
                                                                <span
                                                                    class="text-muted font-weight-bold">{{ ${$item}->phone_number}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div
                                                            class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="mailto:{{${$item}->email}}"
                                                                   class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.email') }}</a>
                                                                <span
                                                                    class="text-muted font-weight-bold">{{ ${$item}->email }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div
                                                            class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#"
                                                                   class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.subject') }}</a>
                                                                <span
                                                                    class="text-muted font-weight-bold">{{ ${$item}->subject ??   __('admin.empty') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div
                                                            class="d-flex align-items-center mb-9 bg-light-secondary rounded p-5">
                                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                                <a href="#"
                                                                   class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ __($item.'.message') }}</a>
                                                                <span
                                                                    class="text-muted font-weight-bold">{!!  ${$item}->message ??  __('admin.empty')  !!}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="border-bottom w-100 m-4 mt-9"></div>
                                                <div class="d-flex flex-column align-items-md-start px-0">
                                                    <span class="font-weight-bolder mb-2">{{__('admin.images')}}</span>
                                                </div>
                                                <div class="d-flex justify-content-start mr-2 pt-6">
                                                        @foreach(${$item}->getMedia('images') as $image)
                                                            <div class="d-flex flex-column align-items-md-end px-5">
                                                                <!--begin::Logo-->
                                                                <a href="{{ $image->getFullUrl() }}" class="mb-5 fancybox">
                                                                    <div class="symbol symbol-100 flex-shrink-0 mr-2">
                                                                        <div class="symbol-label"
                                                                             style="background-image: url({{ $image->getFullUrl() }})">
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <!--end::Logo-->
                                                            </div>
                                                        @endforeach
                                                </div>

                                                @if(${$item}->getFirstMedia('attachments'))
                                                <div class="border-bottom w-100 m-4 mt-9"></div>
                                                <div class="d-flex flex-column align-items-md-start px-0">
                                                    <span class="font-weight-bolder mb-2">{{__('contact.attachment')}}</span>
                                                </div>
                                                <div class="d-flex justify-content-start mr-2 pt-6">
                                                    @foreach(${$item}->getMedia('attachments') as $image)
                                                        <div class="d-flex flex-column align-items-md-center px-15">
                                                            <!--begin::Logo-->
                                                            <a href="{{ $image->getFullUrl() }}" class="mb-5" download rel="noopener noreferrer" target="_blank">
                                                                <div class="symbol symbol-100 flex-shrink-0 mr-2">
                                                                    <div class="symbol-label"
                                                                         style="background-image: url({{ $image->getFullUrl() }})">
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <!--end::Logo-->
                                                            <h4 class="font-weight-bold my-2">{{$image->file_name}}</h4>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                            <br><br>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::Container-->
</x-master>
