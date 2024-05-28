<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Register</title>
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

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4 font-weight-bold">Create Account</h1>
                            </div>
                            <form id="registerForm" class="user" action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark" for="">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email:">
                                    <div id="errEmail"></div>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark" for="">Full Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Full Name:">
                                    <div id="errName"></div>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark" for="">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password:">
                                    <div id="errPassword"></div>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark" for="">Confirm Password:</label>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password:">
                                    <div id="errPasswordConfirm"></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light border-0 small" id="captcha" name="captcha" placeholder="Captcha...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-danger" type="button" id="reload" title="Reload Captcha">
                                                        <i class="fas fa-sync-alt fa-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="errCaptcha"></div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <div class="captcha">
                                                <span>{!! Captcha::img('flat') !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold"><i class="fas fa-spinner fa-spin" style="display:none;"></i>
                                    <span class="text-loader">Create Account!</span>
                                </button>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js') }}"></script> -->
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* toast file */
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
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('register') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $("#pageloader").fadeOut();
                        $(".btn .fa-spinner").hide();
                        $(".btn .text-loader").html("Create Account");
                        $('#registerForm')[0].reset();
                        return Toast.fire({
                            icon: res.status,
                            title: res.message
                        });
                    },
                    error: function(err) {
                        let error = err.responseJSON;
                        let errorEmail = error.errors.email;
                        let errorName = error.errors.name;
                        let errorPassword = error.errors.password;
                        let errorPasswordConfirm = error.errors.password_confirm;
                        let errorCaptcha = error.errors.captcha;
                        $('#errEmail').append(errorEmail && !$('#errEmail').text().includes(errorEmail) ? '<span class="text-danger">' + errorEmail + '</span><br/>' : '');
                        $('#errName').append(errorName && !$('#errName').text().includes(errorName) ? '<span class="text-danger">' + errorName + '</span><br/>' : '');
                        $('#errPassword').append(errorPassword && !$('#errPassword').text().includes(errorPassword) ? '<span class="text-danger">' + errorPassword + '</span><br/>' : '');
                        $('#errPasswordConfirm').append(errorPasswordConfirm && !$('#errPasswordConfirm').text().includes(errorPasswordConfirm) ? '<span class="text-danger">' + errorPasswordConfirm + '</span><br/>' : '');
                        $('#errCaptcha').append(errorCaptcha && !$('#errCaptcha').text().includes(errorCaptcha) ? '<span class="text-danger">' + errorCaptcha + '</span><br/>' : '');
                        $.each(error.errors, function(index, value) {
                            return Toast.fire({
                                icon: "error",
                                title: value
                            });
                        })
                        $(".pageloader").fadeOut();
                        $(".btn .fa-spinner").hide();
                        $(".btn .text-loader").html("Create Account");
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
            $("#registerForm").on("submit", function() {
                $(".btn .fa-spinner").show();
                $(".btn .text-loader").html("Loading");
            });
        });
    </script>
</body>

</html>