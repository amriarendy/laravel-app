@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Profil</h1>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">Profile</h5>
            </div>
            <div class="card-body">
                <form class="form" action="" id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="col-form-label font-weight-bold">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}" readonly />
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label font-weight-bold">Nama:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" />
                        <div id="errNameEdit"></div>
                    </div>
                    <div class="form-group">
                        <label for="picture" class="col-form-label font-weight-bold">Foto Profil:</label>
                        <input type="file" class="form-control" name="picture" id="pictureEdit" accept="image/*">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="cropped" id="croppedImage" value="">
                    </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="editBtn" class="btn btn-primary font-weight-bold"> <i class="fas fa-spinner fa-spin" style="display:none;"></i>
            <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
          </button>
            </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">Change Password</h5>
            </div>
            <div class="card-body">
                <form class="form" action="" id="passForm" name="passForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="password" class="col-form-label font-weight-bold">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" />
                        <div id="errPassChg"></div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm" class="col-form-label font-weight-bold">Konfirmasi Password:</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" />
                        <div id="errPassChgConfirm"></div>
                    </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="passBtn" class="btn btn-primary font-weight-bold"> <i class="fas fa-spinner fa-spin" style="display:none;"></i>
            <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
          </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Croppie -->
<div class="modal fade" id="croppieModal" tabindex="-1" aria-labelledby="croppieModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="croppieModalLabel">Crop Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="imageShow" class="img-fluid mt-1 mb-1 border border-black"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="croppieBtn" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- ./Modal Croppie -->
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    /* Edit Data */
    $(document).on('submit', '#editForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('profile.update') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $("#pageloader").fadeOut();
                $(".btn .fa-spinner").hide();
                $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                if (res.code == 200) {
                    $('#editModal').modal('hide');
                    $('#editForm')[0].reset();
                    // window.location = "{{ route('profile') }}";
                    $('.table').load(location.href + ' .table');
                    return Toast.fire({
                        icon: "success",
                        title: '<b class="text-success">Success</b>',
                        text: "success update data!",
                    });
                }
            },
            error: function(err) {
                let error = err.responseJSON;
                let errorName = error.errors.name;
                let errorBio = error.errors.bio;
                $('#errNameEdit').append(errorName && !$('#errNameEdit').text().includes(errorName) ? '<span class="text-danger">' + errorName + '</span><br/>' : '');
                $('#errBioEdit').append(errorBio && !$('#errBioEdit').text().includes(errorBio) ? '<span class="text-danger">' + errorBio + '</span><br/>' : '');
                $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    return Toast.fire({
                        icon: "error",
                        title: '<b class="text-danger">Unprocessable Content</b>',
                        text: "unable to be followed due to semantic errors.",
                    });
            }
        });
    });

    $(document).on('submit', '#passForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('profile.password') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $("#pageloader").fadeOut();
                $(".btn .fa-spinner").hide();
                $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                if (res.code == 200) {
                    $('#passForm')[0].reset();
                    $('.table').load(location.href + ' .table');
                    return Toast.fire({
                        icon: "success",
                        title: '<b class="text-success">Success</b>',
                        text: "success update data!",
                    });
                }
            },
            error: function(err) {
                let error = err.responseJSON;
                let errorPassword = error.errors.password;
                let errorPasswordConfirm = error.errors.password_confirm;
                $('#errPassChg').append(errorPassword && !$('#errPassChg').text().includes(errorPassword) ? '<span class="text-danger">' + errorPassword + '</span><br/>' : '');
                $('#errPassChgConfirm').append(errorPasswordConfirm && !$('#errPassChgConfirm').text().includes(errorPasswordConfirm) ? '<span class="text-danger">' + errorPasswordConfirm + '</span><br/>' : '');
                $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    return Toast.fire({
                        icon: "error",
                        title: '<b class="text-danger">Unprocessable Content</b>',
                        text: "unable to be followed due to semantic errors.",
                    });
            }
        });
    });

    /* croppie */
    $(document).ready(function() {
        $image_crop = $('#imageShow').croppie({
            enableExif: true,
            viewport: {
                width: 100,
                height: 100,
                type: 'square',
            },
            boundary: {
                width: 300,
                height: 300
            },
            showZoomer: true,
            enableResize: false,
            enableOrientation: true,
            mouseWheelZoom: 'ctrl',
            zoom: 1.5,
        })

        $('#pictureEdit').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(event) {
                $image_crop.croppie('bind', {
                    url: event.target.result,
                    points: [50, 50],
                }).then(function() {
                    $('.cr-slider').attr({
                        'min': 0.5000,
                        'max': 1.5000
                    });
                    return toastr['success']("jQuery bind complete");
                    console.log('jQuery bind complete')
                })
            }
            reader.readAsDataURL(this.files[0]);
            $('#croppieModal').modal('show');
        })

        $('#croppieBtn').click(function(e) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport',
            }).then(function(res) {
                $('#croppedImage').val(res);
                $('#croppieModal').modal('hide');
            });
        });
    });
</script>

@endsection