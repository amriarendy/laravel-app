<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard - Starter Company Profile</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />
    <meta name="description" content="Starter Laravel Company Profile" />
    <meta name="keywords" content="amriarendy, landingpage, companyprofile, panel companyprofile, panel administrator" />
    <meta name="author" content="amriarendy" />
    <meta name="image" content="" />
    <meta name="copyright" content="amriarendy" />
    <meta name="canonical" content="{{ URL::current(); }}" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="googlebotnews" content="noindex, nofollow" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- Datatables Vendor CSS -->
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- summernote -->
    <link href="{{ asset('assets/vendor/summernote/summernote.min.css') }}" rel="stylesheet">
    <!-- /.select2 -->
    <link href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <!-- /.toastr -->
    <link href="{{ asset('assets/vendor/toastr/toastr.min.css') }}" rel="stylesheet" />
    <!-- /.sweetalert2 -->
    <link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <!-- /.chart.js -->
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- /.croppie -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- /.croppie -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- /.full calendar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css" integrity="sha512-XcPoWhhzQ3zSKsuBQyysOwTcBiiyh2dVj0tLRL3nvUFIhC7H/98x8GFDpAvqIittlJhPFUCJ5DGTcd3U53IQdw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #pageloader {
            background: rgba(255, 255, 255, 0.8);
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
        }

        #pageloader img {
            left: 50%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
        }

        .button {
            position: relative;
            padding: 8px 16px;
            background: #009579;
            border: none;
            outline: none;
            border-radius: 2px;
            cursor: pointer;
        }

        .button:active {
            background: #007a63;
        }

        .button__text {
            font: bold 20px "Quicksand", san-serif;
            color: #ffffff;
            transition: all 0.2s;
        }

        .button--loading .button__text {
            visibility: hidden;
            opacity: 0;
        }

        .button--loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 4px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
            box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }

            to {
                transform: rotate(1turn);
            }
        }
    </style>
</head>

<body id="page-top">
    <div id="pageloader">
        <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="on loading..." />
    </div>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-black sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/')}}">
                <img class="img-fluid px-1 px-sm-1 mt-1 mb-1" src="https://laravel.com/img/logomark.min.svg" alt="website icon">
                <img class="img-fluid px-1 px-sm-1 mt-1 mb-1" src="https://laravel.com/img/logotype.min.svg" alt="website icon">
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                ADMINISTRATOR
            </div>

            <!-- Nav Item - Content Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArticle" aria-expanded="true" aria-controls="collapseArticle">
                    <i class="fas fa-newspaper"></i>
                    <span>Content</span>
                </a>
                <div id="collapseArticle" class="collapse" aria-labelledby="headingContent" data-parent="#accordionSidebar">
                    <div class="bg-black py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Writter Content:</h6>
                        <a class="collapse-item" href="{{route('blog')}}">Blogs</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Master Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsMaster" aria-expanded="true" aria-controls="collapsMaster">
                    <i class="fas fa-database"></i>
                    <span>Master Data</span>
                </a>
                <div id="collapsMaster" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
                    <div class="bg-black py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Master Data:</h6>
                        <a class="collapse-item" href="{{route('category')}}">Master Categories</a>
                        <a class="collapse-item" href="{{route('tag')}}">Master Tags</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Users Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
                    <div class="bg-black py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Users:</h6>
                        <a class="collapse-item" href="{{route('users')}}">Users Data</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Setting & Information
            </div>

            <!-- Nav Item - Setting Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Setting</span>
                </a>
                <div id="collapseSetting" class="collapse" aria-labelledby="headingSetting" data-parent="#accordionSidebar">
                    <div class="bg-black py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Setting Menu:</h6>
                        <a class="collapse-item" href="{{ route('/') }}">Meta Data</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('/') }}">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>Information</span></a>
            </li>

            <!-- Divider -->

            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item">
                <a class="nav-link text-danger font-weight-bold" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span>{{ __('Log Out') }}</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-black topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-light-600 font-weight-bold small">{{ Auth::user()->name; }}</span>
                                <div class="topbar-divider d-none d-sm-block"></div>
                                <img class="img-profile rounded-circle" src="{{ asset(Auth::user()->picture) }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{route('/')}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="{{route('/')}}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="{{route('/')}}">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger font-weight-bold" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                                    {{ __('Log Out') }}
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Development by <b>Amria Rendy</b></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Klik <span class="text-danger font-weight-bold">LogOut</span> Untuk Keluar Dari Aplikasi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="btn btn-danger" href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-light"></i>{{ __('Log Out') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <!-- Datatables Vendor Javascript -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- /.summernote -->
    <script src="{{ asset('assets/vendor/summernote/summernote.min.js') }}"></script>
    <!-- /.select2 -->
    <script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
    <!-- /.toastr -->
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
    <!-- /.sweetalert2 -->
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!-- /.momentjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" referrerpolicy="no-referrer"></script>
    <!-- /.fullcalender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js" integrity="sha512-7IbO+IEofZ03ixCjeRlF6cSHn50WA1m2sfc8hW2lWK6YVjrvKu+pZ2hNBHYEVupZJTj4R2kh3QPVK1qF25Louw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* Call the dataTables jQuery plugin */
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        /* summernote */
        $('.compose-textarea').summernote({
            tabsize: 2,
            height: 500,
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            }
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "{{ route('image.upload') }}",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(response) {
                    console.log(response)
                    $('.compose-textarea').summernote("insertImage", response.url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            var filename = src.split('/').pop();
            $.ajax({
                type: 'POST',
                url: "{{ route('image.delete') }}",
                data: {
                    filename: filename,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    return toastr[res.status](res.status, res.message);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error deleting image: ' + textStatus);
                }
            });
        }

        /* select2 */
        $(document).ready(function() {
            $('.multiple-select2').select2();
        });

        /* trim slug */
        var slug = function(str) {
            var $slug = '';
            var trimmed = $.trim(str);
            $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            replace(/-+/g, '-').
            replace(/^-|-$/g, '');
            return $slug.toLowerCase();
        }
        $('.title').on('keyup', function() {
            $('.slug').val(slug($(this).val()));
        });

        /* checkbox slug */
        $(document).ready(function() {
            $('.checkboxSlug').click(function() {
                if ($(this).is(':checked')) {
                    $('.slug').attr('readonly', false);
                } else {
                    $('.slug').attr('readonly', true);
                }
            })
        })

        /* checkbox datepost */
        $(document).ready(function() {
            $('#checkboxDate').click(function() {
                if ($(this).is(':checked')) {
                    $('#date_post').attr('readonly', false);
                } else {
                    $('#date_post').attr('readonly', true);
                }
            })
        })

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

        /* page loader */
        $(document).ready(function() {
            $(".form").on("submit", function() {
                $("#pageloader").fadeIn();
                $(".btn .fa-spinner").show();
                $(".btn .text-loader").html("Loading");
            });
        });

        // close btn for reset form
        $(document).ready(function() {
            $(".closeBtn").on("click", function() {
                $('.form')[0].reset();
            });
        });
    </script>
</body>

</html>