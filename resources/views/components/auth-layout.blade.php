<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="Sabuj" name="author" />
    <meta name="currency" content="{{ getCurrencySymbol() }}" />
    <!-- App favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .btn-primary {
            color: #fff;
            background-color: #0096c7;
            border-color: #0096c7;
        }

        .btn-primary:hover {
            background-color: #50b6d8;
            border-color: #50b6d8;
        }

        .bg-right-box {
            position: absolute;
            background-repeat: no-repeat;
            background-size: cover;
            left: -10px;
            top: -10px;
            right: -10px;
            bottom: -10px;
            z-index: -1;
            filter: blur(10px);
        }

        .inner-content {
            height: calc(100% - 20px);
            padding: 10px 25px;
        }

        .gr {
            background: -moz-linear-gradient(top, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 100%);
            background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 100%);
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#66ffffff', endColorstr='#1affffff', GradientType=0);
            border-radius: 20px;
            padding: 40px;
        }

        .imgbox-carousal img {
            max-height: 80vh;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex vh-100 ">
                {{ $slot }}
            </div>
            <div class="col align-self-end p-0 d-none d-md-block vh-100">
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-interval="3000">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active" style="height: 100vh;">
                            <div class="bg-right-box" style="background-image:url(images/dummy.png)">
                            </div>
                            <div class="d-flex inner-content align-center justify-center">
                                <div class="gr align-self-center mx-auto">
                                    <div>
                                        <div class="imgbox-carousal mx-auto">
                                            <img src="images/dummy.png">
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
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
