@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Create Blog</h1>
</div>

<!-- Content Row -->
<form class="form" action="" id="addForm" name="addForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold" for="title">Title <span style="color: red;">*</span></label>
                        <input type="text" class="form-control title" id="title" name="title">
                        <div id="errTitle"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold" for="slug">Slug <span style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input class="checkboxSlug" type="checkbox" />
                                </span>
                            </div>
                            <input type="text" class="form-control slug" id="slug" name="slug" value="" maxlength="100" readonly>
                        </div>
                        <div id="errSlug"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold" for="category">Category <span style="color: red;">*</span></label>
                        <select class="form-control" name="category">
                            <option value="">-Choose Category-</option>
                            @foreach ($categories as $row)
                            <option value="{{ $row->category }}">{{ $row->category }}</option>
                            @endforeach
                        </select>
                        <div id="errCategory"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold" for="archives">File</label>
                        <input type="file" class="form-control" id="archives" name="archives[]" multiple="multiple" placeholder="file: " />
                        <div id="errArchives"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold" for="image">Thumbnail</label>
                        <input type="file" class="form-control" name="beforeCroppie" id="beforeCroppie" accept="image/*">
                        <div id="errImage"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold" for="date_post">Tanggal Posting <span style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input type="checkbox" id="checkboxDate">
                                </span>
                            </div>
                            <input type="datetime-local" class="form-control" id="date_post" name="date_post" value="{{  now()->toDateTimeString() }}" readonly>
                        </div>
                    </div>
                    <div id="errDatePost"></div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="font-weight-bold" for="keyword">Keyword</label>
                        <select class="form-control multiple-select2" name="tag[]" multiple="multiple">
                            @foreach ($keywords as $row)
                            <option value="{{ $row->tag }}">{{ $row->tag }}</option>
                            @endforeach
                        </select>
                        <div id="errKeyword"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="font-weight-bold" for="description">Description <span style="color: red;">*</span></label>
                        <textarea type="text" class="form-control" name="description" cols="30" rows="3"></textarea>
                        <div id="errDescription"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="font-weight-bold" for="body">Content Body</label>
                        <textarea class="form-control compose-textarea" name="body" cols="30" rows="3"></textarea>
                        <div id="errBody"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="croppedImage" id="croppedImage" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" id="addBtn" class="btn btn-primary btn-block font-weight-bold"> <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
            </button>
        </div>
    </div>
</form>

<!-- Modal Croppie -->
<div class="modal fade" id="croppieModal" aria-labelledby="croppieModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="croppieModalLabel">Crop Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="imageShow" class="img-fluid mt-1 mb-1 border border-black" style="overflow: auto;"></div>
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
    $(document).ready(function() {
        $('#addForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            /* Add the cropped image data to the form data */
            formData.append('croppedImage', $('#croppedImage').val());
            $.ajax({
                url: "{{ route('blog.store') }}",
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {
                    $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    if (res.code == 200) {
                        $('#addForm')[0].reset();
                        window.location = "{{ route('blog.list') }}";
                        return Toast.fire({
                            icon: "success",
                            title: '<b class="text-success">Success</b>',
                            text: "success create data!",
                        });
                    }
                },
                error: function(err) {
                    let error = err.responseJSON;
                    let errorTitle = error.errors.title;
                    let errorDescription = error.errors.description;
                    let errorCategory = error.errors.category;
                    let errorBody = error.errors.body;
                    let errorImage = error.errors.image;
                    let errorArchives = error.errors.archives;
                    let errorSlug = error.errors.slug;
                    let errorDatePost = error.errors.date_post;
                    $('#errTitle').append(errorTitle && !$('#errTitle').text().includes(errorTitle) ? '<span class="text-danger">' + errorTitle + '</span><br/>' : '');
                    $('#errDescription').append(errorDescription && !$('#errDescription').text().includes(errorDescription) ? '<span class="text-danger">' + errorDescription + '</span><br/>' : '');
                    $('#errCategory').append(errorCategory && !$('#errCategory').text().includes(errorCategory) ? '<span class="text-danger">' + errorCategory + '</span><br/>' : '');
                    $('#errBody').append(errorBody && !$('#errBody').text().includes(errorBody) ? '<span class="text-danger">' + errorBody + '</span><br/>' : '');
                    $('#errImage').append(errorImage && !$('#errImage').text().includes(errorImage) ? '<span class="text-danger">' + errorImage + '</span><br/>' : '');
                    $('#errArchives').append(errorArchives && !$('#errArchives').text().includes(errorArchives) ? '<span class="text-danger">' + errorArchives + '</span><br/>' : '');
                    $('#errSlug').append(errorSlug && !$('#errSlug').text().includes(errorSlug) ? '<span class="text-danger">' + errorSlug + '</span><br/>' : '');
                    $('#errDatePost').append(errorDatePost && !$('#errDatePost').text().includes(errorDatePost) ? '<span class="text-danger">' + errorDatePost + '</span><br/>' : '');
                    $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    return Toast.fire({
                        icon: "error",
                        title: '<b class="text-danger">Unprocessable Content</b>',
                        text: "unable to be followed due to semantic errors.",
                    });
                }
            })
        })
    })

    /* croppie */
    $(document).ready(function() {
        $image_crop = $('#imageShow').croppie({
            enableExif: true,
            viewport: {
                width: 250,
                height: 200,
                type: 'square',
            },
            boundary: {
                width: 250,
                height: 200,
            },
            showZoomer: true,
            enableResize: false,
            enableOrientation: true,
            mouseWheelZoom: 'ctrl',
            zoom: 1.5,
        })

        $('#beforeCroppie').on('change', function() {
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
                    return Toast.fire({
                        icon: "success",
                        title: '<b class="text-success">Success</b>',
                        text: "jQuery bind complete.",
                    });
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