<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <title>ترسية - Tarsyah</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet"
          href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet" href="https://unpkg.com/filepond@4.30.4/dist/filepond.min.css">
    <style>
        .contact-details {
            position: sticky;
            left: 0;
            top: 0;
            width: 100%;
            padding-top: 32px;
        }

        .filepond--credits {
            display: none;
        }

        @media only screen and (max-width: 567px) {
            .ftco-section {
                padding: 2em 0;
            }

            .contact-details {
                position: static;
            }
        }
    </style>
</head>
<body>
<section class="ftco-section">
    <div class="container">

        <div class="row justify-content-center">

            {{--            <div class="col-md-6 text-center mb-5">--}}
            {{--                <h2 class="heading-section">الرجاء ملئ الحقول:</h2>--}}
            {{--            </div>--}}
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters">
                        <div class="col-md-7 d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <div class=" text-center mb-2">
                                    <img src="{{asset('images/nwc_logo.png')}}" alt="" style="height: 300px;">
                                </div>
                                <h3 class="mb-4 text-right">المعلومات الشخصية</h3>
                                <div id="form-message-warning" style="display: block" class="mb-4 text-right">
                                    @if($errors->any())
                                        {{ implode('', $errors->all(':message')) }}
                                    @endif
                                </div>
                                <form method="POST" id="contactForm" name="contactForm" action="{{route('submit')}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                @error('name')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                                <input type="text" class="form-control" name="name" id="name"
                                                       placeholder="الاسم" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                @error('email')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                                <input type="email" class="form-control" name="email" id="email"
                                                       placeholder="الايميل">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                @error('id_number')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                                <input type="text" class="form-control" name="id_number" id="email"
                                                       placeholder="رقم الهوية">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                @error('phone_number')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                                <input type="text" class="form-control" name="phone_number"
                                                       id="phone_number"
                                                       placeholder="رقم الجوال" required>
                                            </div>
                                        </div>
{{--                                        <div class="col-12">--}}
{{--                                            <h4 class="mb-4 text-right">العقار المطلوب المزاودة عليه</h4>--}}

{{--                                            <div class="form-group text-right" style="white-space: nowrap;">--}}
{{--                                                @error('items')--}}
{{--                                                <h4 class="error">{{ $message }}</h4>--}}
{{--                                                @enderror--}}
{{--                                                <div class="row">--}}
{{--                                                    <label class="checkbox-inline col-6 text-justify">--}}
{{--                                                        <input type="checkbox" id="items" name="items[]"--}}
{{--                                                               value="أرض مرات"> أرض مرات--}}
{{--                                                    </label>--}}
{{--                                                    <label class="checkbox-inline col-6 text-justify">--}}
{{--                                                        <input type="checkbox" id="items" name="items[]"--}}
{{--                                                               value="أرض الخرج"> أرض الخرج--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                                <div class="row">--}}
{{--                                                <label class="checkbox-inline col-12 text-justify">--}}
{{--                                                    <input type="checkbox" id="items" name="items[]"--}}
{{--                                                           value="عمارة تجارية بالرياض"> عمارة تجارية بالرياض--}}
{{--                                                </label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        {{--                                        <div class="col-md-12">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                @error('message')--}}
                                        {{--                                                <div class="error">{{ $message }}</div>--}}
                                        {{--                                                @enderror--}}
                                        {{--                                                <textarea name="message" class="form-control" id="message" cols="30"--}}
                                        {{--                                                          rows="7" placeholder="الوصف" required></textarea>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                @error('images')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                                <label for="images" class="d-block text-right">صور الشيك <small>(إن
                                                        وجد)</small></label>
                                                <input type="file" class="images" name="images[]" accept="image/*"/>
                                            </div>
                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                @error('attachments')--}}
                                            {{--                                                <div class="error">{{ $message }}</div>--}}
                                            {{--                                                @enderror--}}
                                            {{--                                                <label for="attachments" class="d-block text-right">  وثائق اضافية <small>(ليس إلزاميا)</small></label>--}}
                                            {{--                                                <input type="file" class="attachments" name="attachments[]"/>--}}
                                            {{--                                            </div>--}}
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" value="إرسال"
                                                       class="btn btn-primary d-block w-100">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-stretch">
                            <div class="info-wrap bg-primary w-100 p-lg-5 p-4">
                                <div class="contact-details" style="">

                                    <div class=" text-center mb-2">
                                        <img src="{{asset('images/logo.png')}}" alt=""
                                             style="height: 150px; background-color: #FFFFFF">
                                    </div>

                                    <h3 class="mb-4 mt-md-4 text-right">الإتصال بنا</h3>

                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-phone"></span>
                                        </div>
                                        <div class="text pr-3">
                                            <p class="text-right" style="direction: ltr"><a href="tel://+966551500035">+966
                                                    551 500 035</a></p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-envelope"></span>
                                        </div>
                                        <div class="text pr-3">
                                            <p class="text-right"><a
                                                    href="mailto:fahad@tarsyah.com">Fahad@tarsyah.com</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-envelope"></span>
                                        </div>
                                        <div class="text pr-3">
                                            <p class="text-right"><a
                                                    href="mailto:ceo@tarsyah.com">ceo@tarsyah.com</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-globe"></span>
                                        </div>
                                        <div class="text pr-3">
                                            <p class="text-right"><a href="https://tarsyah.com/">tarsyah.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/popper.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/front/contactPage.js')}}"></script>

</body>
</html>

