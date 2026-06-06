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

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/favicon/site.webmanifest') }}">

    @stack('vendor_css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <!-- Sweet Alert-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        .alert-error {
            color: #99253a;
            background-color: #ffd8df;
            border-color: #ffc5cf
        }

        .dt-body-nowrap {
            white-space: nowrap
        }

        .dt-body-right {
            text-align: right
        }

        .card-header {
            background-color: #1b2c3f
        }

        .card-header .card-title {
            color: #fff;
            margin-bottom: 0;
            line-height: 28px;
            text-transform: uppercase
        }

        .lds-spinner {
            color: official;
            display: inline-block;
            position: relative;
            width: 36px;
            height: 36px
        }

        .lds-spinner div {
            transform-origin: 18px 18px;
            animation: lds-spinner 1.2s linear infinite
        }

        .lds-spinner div:after {
            content: " ";
            display: block;
            position: absolute;
            top: 3px;
            left: 18px;
            width: 3px;
            height: 9px;
            border-radius: 20%;
            background: #1b2c3f
        }

        .lds-spinner div:nth-child(1) {
            transform: rotate(0);
            animation-delay: -1.1s
        }

        .lds-spinner div:nth-child(2) {
            transform: rotate(30deg);
            animation-delay: -1s
        }

        .lds-spinner div:nth-child(3) {
            transform: rotate(60deg);
            animation-delay: -.9s
        }

        .lds-spinner div:nth-child(4) {
            transform: rotate(90deg);
            animation-delay: -.8s
        }

        .lds-spinner div:nth-child(5) {
            transform: rotate(120deg);
            animation-delay: -.7s
        }

        .lds-spinner div:nth-child(6) {
            transform: rotate(150deg);
            animation-delay: -.6s
        }

        .lds-spinner div:nth-child(7) {
            transform: rotate(180deg);
            animation-delay: -.5s
        }

        .lds-spinner div:nth-child(8) {
            transform: rotate(210deg);
            animation-delay: -.4s
        }

        .lds-spinner div:nth-child(9) {
            transform: rotate(240deg);
            animation-delay: -.3s
        }

        .lds-spinner div:nth-child(10) {
            transform: rotate(270deg);
            animation-delay: -.2s
        }

        .lds-spinner div:nth-child(11) {
            transform: rotate(300deg);
            animation-delay: -.1s
        }

        .lds-spinner div:nth-child(12) {
            transform: rotate(330deg);
            animation-delay: 0s
        }

        .required:after {
            content: '*';
            color: red;
            padding-left: 5px;
        }

        @keyframes lds-spinner {
            0% {
                opacity: 1
            }

            100% {
                opacity: 0
            }
        }

        @media (max-width:767px) {
            .dt-body-right.text-xs-align-left {
                text-align: left
            }
        }

        @if (app()->environment('local'))
            body[data-sidebar=dark] .navbar-brand-box {
                background: #3964bf;
            }
        @endif
        
    </style>
    @stack('css')
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box text-center">
                        <a href="{{ route('home') }}" class="logo logo-dark">
                            <span class="logo-sm" style="overflow: hidden;">
                                <img src="{{ $logo }}" alt="logo-sm-dark" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ $logo }}" alt="logo-dark" height="48">
                            </span>
                        </a>

                        <a href="{{ route('home') }}" class="logo logo-light d-flex">
                            <span class="logo-sm" style="overflow: hidden;">
                                <img src="{{ $logo }}" alt="logo-sm-light" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ $logo }}" alt="logo-light" height="48">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>
                </div>

                <div class="d-flex">

                    @auth
                        <x-notifications />
                    @endauth

                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('assets/images/users/avatar-2.jpg') }}" alt="Header Avatar">
                            @if (auth()->check())
                                <span class="d-none d-xl-inline-block ms-1">{{ auth()->user()->name }}</span>
                            @endif
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ route('profile') }}"><i
                                    class="ri-user-line align-middle me-1"></i>
                                Profile</a>

                            <a class="dropdown-item d-block" href="#"><span
                                    class="badge bg-success float-end mt-1">11</span><i
                                    class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i
                                    class="ri-lock-unlock-line align-middle me-1"></i>
                                Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item text-danger" href="#">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <i class="ri-shut-down-line align-middle me-1 text-danger"></i>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <x-sidebar-navigation />



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            {{ $slot }}

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © {{ config('app.name') }}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Crafted with <i class="mdi mdi-heart text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <div class="modal fade" id="showMoreModal" tabindex="-1" role="dialog"
                aria-labelledby="showMoreModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body"></div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('vendorjs')
    <script>
        function buildSearchData(object) {
            if (object.start > 0) {
                object.page = (object.start / object.length) + 1;
            }
            @if (request()->has('trash'))
                object.trash = 1;
            @endif
            return object;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        function formatted_amount(amount) {
            const symbol = "{{ getCurrencySymbol() }}";
            return symbol + " " + (Math.round(amount * 100) / 100).toFixed(2);
        }

        function isInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)

            );
        }


        function onClickShowHandeler(element) {
            $('#showMoreModal').modal('show');
            $.ajax({
                    url: $(element).data('route'),
                    type: 'get',
                })
                .done(function(response) {
                    $("#showMoreModal .modal-title").html(response.title);
                    $("#showMoreModal .modal-body").html(response.body);
                })
                .fail(function(response) {
                    $('#showMoreModal').modal('hide');
                    if (response.status === 419) {
                        Swal.fire("Cancelled!", response.responseJSON.message, "error")
                    } else {
                        Swal.fire("Cancelled!", response.statusText, "error")
                    }
                });
        }

        function onClickDeleteHandeler(element) {
            Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: $(element).data('desc') ?? "{!! __("You won't be able to revert this!") !!}",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#1cbb8c",
                cancelButtonColor: "#ff3d60",
                confirmButtonText: '{{ __('Yes, delete it!') }}'
            }).then(function(t) {
                if (t.isConfirmed) {
                    $.ajax({
                            url: $(element).data('route'),
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                        })
                        .done(function() {
                            Swal.fire("Deleted!", "Your item has been deleted.", "success");
                            if ($(element).data('redirect')) {
                                location.href = $(element).data('redirect');
                            } else {
                                table.ajax.reload(null, false);
                            }
                        })
                        .fail(function(response) {
                            if (response.status === 419) {
                                Swal.fire("Cancelled!", response.responseJSON.message, "error")
                            } else {
                                Swal.fire("Cancelled!", response.statusText, "error")
                            }
                        });
                }
            })
        }

        $(document).ready(function() {
            $("input[required]").parents('.form-group').find('label').addClass('required');
            $("select[required]").parents('.form-group').find('label').addClass('required');

            $(document).on('keypress', '.numberonly', function(e) {

                var charCode = (e.which) ? e.which : event.keyCode

                if (String.fromCharCode(charCode).match(/[^0-9.]/g))

                    return false;

            });
        });

        function bd_money_format(x) {
            x = parseFloat(x).toFixed(2)
            if (isNaN(x)) return x;

            x = x.toString();
            var afterPoint = '';
            if (x.indexOf('.') > 0)
                afterPoint = x.substring(x.indexOf('.'), x.length);
            x = Math.floor(x);
            x = x.toString();
            var lastThree = x.substring(x.length - 3);
            var otherNumbers = x.substring(0, x.length - 3);
            if (otherNumbers != '')
                lastThree = ',' + lastThree;
            var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
            return res;
        }
    </script>
    @stack('js')

</body>

</html>
