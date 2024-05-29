<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="" />
    <meta name="description" content="" />
    <meta name="author" content="amriarendy" />
    <meta name="image" content="" />
    <meta name="copyright" content="amriarendy" />
    <meta name="canonical" content="" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="googlebotnews" content="noindex, nofollow" />
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet" />
    <style>
        .pageloader {
            background: rgba(255, 255, 255, 0.8);
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
        }

        .pageloader img {
            left: 50%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
        }
    </style>
</head>

<body class="bg-gradient-black">
    <div class="pageloader">
        <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="on loading..." />
    </div>
    <div class="container">
        
        @yield('content')

    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* mixin alert */
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('login') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $(".pageloader").fadeOut();
                        $(".btn .fa-spinner").hide();
                        $(".btn .text-loader").html("Submit");
                        $('#loginForm')[0].reset();
                        window.location = "{{ route('dashboard') }}";
                        return Toast.fire({
                            icon: "success",
                            title: value
                        });
                    },
                    error: function(err) {
                        let error = err.responseJSON;
                        let errorEmail = error.errors.email;
                        let errorPassword = error.errors.password;
                        let errorCaptcha = error.errors.captcha;
                        $('#errEmail').append(errorEmail && !$('#errEmail').text().includes(errorEmail) ? '<span class="text-danger">' + errorEmail + '</span><br/>' : '');
                        $('#errPassword').append(errorPassword && !$('#errPassword').text().includes(errorPassword) ? '<span class="text-danger">' + errorPassword + '</span><br/>' : '');
                        $('#errCaptcha').append(errorCaptcha && !$('#errCaptcha').text().includes(errorCaptcha) ? '<span class="text-danger">' + errorCaptcha + '</span><br/>' : '');
                        $(".pageloader").fadeOut();
                        $(".btn .fa-spinner").hide();
                        $(".btn .text-loader").html("Login");
                        return Toast.fire({
                            icon: "error",
                            title: '<b class="text-danger">Unprocessable Content:</b> unable to be followed due to semantic errors.'
                        });
                    }
                })
            })
        })

        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: "{{ route('reload.captcha') }}",
                success: function(data) {
                    $(".captcha span").html(data.captcha)
                }
            });
        });

        $(document).ready(function() {
            $("#loginForm").on("submit", function() {
                $(".pageloader").fadeIn();
                $(".btn .fa-spinner").show();
                $(".btn .text-loader").html("Loading");
            });
        });
    </script>
</body>

</html>