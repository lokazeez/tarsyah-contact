<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <title>ترسية - Tarsyah</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/dropify.css')}}">
</head>
<body>
<section class="ftco-section">
    <div class="container">

        <div class="row justify-content-center">
            <a href="/">
                <div class="col-md-6 text-center mb-5">
                    <img src="{{asset('images/logo.png')}}" alt="" style="height: 100px; width: 100px">
                </div>
            </a>
            {{--            <div class="col-md-6 text-center mb-5">--}}
            {{--                <h2 class="heading-section">الرجاء ملئ الحقول:</h2>--}}
            {{--            </div>--}}
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="wrapper">
                    <div class="alert alert-primary text-center" role="alert">
                        تم تسجيل طلبكم
                        سيتم التواصل معكم قريبا
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
<script src="{{asset('js/app.js')}}"></script>
<script src="{{ asset('js/dropify.js' )}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.dropify').dropify();
    });
</script>
</body>
</html>

