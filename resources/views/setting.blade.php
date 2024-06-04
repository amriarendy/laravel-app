@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Settings</h1>
    <a href="#" id="linkButton" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-database fa-sm text-white-50"></i> Backup Database</a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="font-weight-bold text-dark">Meta & SEO</h6>
            </div>
            <form class="form" action="" id="editForm" name="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="font-weight-bold">Title: </label>
                        <input type="text" class="form-control" value="{{ $data->title }}" name="title" />
                        <div id="errTitle"></div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Description: </label>
                        <textarea class="form-control" name="description" cols="30" rows="5">{{$data->description}}</textarea>
                        <div id="errDescription"></div>
                    </div>
                    <div class="form-group">
                        <label for="keywords" class="font-weight-bold">Keywords: </label>
                        <input type="text" class="form-control" value="{{ $data->keywords }}" name="keywords" />
                        <div id="errKeywords"></div>
                    </div>
                    <div class="form-group">
                        <label for="author" class="font-weight-bold">Author</label>
                        <input type="text" class="form-control" value="{{ $data->author }}" name="author" />
                        <div id="errAuthor"></div>
                    </div>
                    <div class="form-group">
                        <label for="copyright" class="font-weight-bold">Copyright</label>
                        <input type="text" class="form-control" value="{{ $data->copyright }}" name="copyright" />
                        <div id="errCopyright"></div>
                    </div>
                    <div class="form-group">
                        <label for="robots" class="font-weight-bold">Robots</label>
                        <select class="form-control" name="robots">
                            <option value="{{ $data->robots }}" selected>{{ $data->robots }}</option>
                            <option value="index, follow">index, follow</option>
                            <option value="follow">follow</option>
                            <option value="noindex, follow">noindex, follow</option>
                            <option value="index, nofollow">index, nofollow</option>
                            <option value="noindex, nofollow">noindex, nofollow</option>
                        </select>
                        <div id="errRobots"></div>
                    </div>
                    <div class="form-group">
                        <label for="googlebot" class="font-weight-bold">Google Bot</label>
                        <select class="form-control" name="googlebot">
                            <option value="{{ $data->googlebot }}" selected>{{ $data->googlebot }}</option>
                            <option value="index, follow">index, follow</option>
                            <option value="follow">follow</option>
                            <option value="noindex, follow">noindex, follow</option>
                            <option value="index, nofollow">index, nofollow</option>
                            <option value="noindex, nofollow">noindex, nofollow</option>
                        </select>
                        <div id="errGoogleBot"></div>
                    </div>
                    <div class="form-group">
                        <label for="googlebotnews" class="font-weight-bold">Google Bot News</label>
                        <select class="form-control" name="googlebotnews">
                            <option value="{{ $data->googlebotnews }}" selected>{{ $data->googlebotnews }}</option>
                            <option value="index, follow">index, follow</option>
                            <option value="follow">follow</option>
                            <option value="noindex, follow">noindex, follow</option>
                            <option value="index, nofollow">index, nofollow</option>
                            <option value="noindex, nofollow">noindex, nofollow</option>
                        </select>
                        <div id="errGoogleBotNews"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="editBtn" class="btn btn-primary btn-block">
                        <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                        <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="font-weight-bold text-dark">Favicon & Image</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Images</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <img class="img-fluid mt-1 mb-1" style="width: 5rem;" src="{{ asset($data->favicon) }}" alt="favicon"><br>
                                    <small>favicon</small>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-warning font-weight-bold" data-toggle="modal" data-target="#faviconModal" title="" style="cursor: pointer;">Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img class="img-fluid mt-1 mb-1" style="width: 5rem;" src="{{ asset($data->image) }}" alt="favicon"><br>
                                    <small>Image</small>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-warning font-weight-bold" data-toggle="modal" data-target="#imageModal" title="" style="cursor: pointer;">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Favicon -->
<div class="modal fade" id="faviconModal" aria-labelledby="faviconModalLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="faviconModalLabel">Crop Favicon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" action="" id="formFavicon" name="formFavicon" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="favicon" class="col-form-label font-weight-bold">Favicon:</label>
                        <input class="form-control" type="file" name="favicon" />
                        <div id="errFavicon"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editBtnFavicon" class="btn btn-primary">
                        <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                        <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ./Modal Favicon -->

<!-- Modal Image -->
<div class="modal fade" id="imageModal" aria-labelledby="imageModalLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="imageModalLabel">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" action="" id="formImage" name="formImage" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="image" class="col-form-label font-weight-bold">Image:</label>
                        <input class="form-control" type="file" name="image" />
                        <div id="errImage"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editImage" class="btn btn-primary">
                        <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                        <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ./Modal Image -->

<!-- Modal Croppie Icon -->
<div class="modal fade" id="iconModal" aria-labelledby="iconModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="iconModalLabel">Crop Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="imageShowIcon" class="img-fluid mt-1 mb-1 border border-black" style="overflow: auto;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="updateIconBtn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- ./Modal Croppie Icon -->

<script>
    /* Meta Edit */
    $(document).on('submit', '#editForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('meta.update') }}",
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
                    // window.location = "{{ route('setting') }}";
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
                let errorKeywords = error.errors.keywords;
                let errorAuthor = error.errors.author;
                let errorCopyright = error.errors.copyright;
                let errorRobots = error.errors.robots;
                let errorGoogleBot = error.errors.googleBot;
                let errorGoogleBotNews = error.errors.googlebotnews;
                $('#errTitle').append(errorTitle && !$('#errTitle').text().includes(errorTitle) ? '<span class="text-danger">' + errorTitle + '</span><br/>' : '');
                $('#errDescription').append(errorDescription && !$('#errDescription').text().includes(errorDescription) ? '<span class="text-danger">' + errorDescription + '</span><br/>' : '');
                $('#errKeywords').append(errorKeywords && !$('#errKeywords').text().includes(errorKeywords) ? '<span class="text-danger">' + errorKeywords + '</span><br/>' : '');
                $('#errAuthor').append(errorAuthor && !$('#errAuthor').text().includes(errorAuthor) ? '<span class="text-danger">' + errorAuthor + '</span><br/>' : '');
                $('#errCopyright').append(errorCopyright && !$('#errCopyright').text().includes(errorCopyright) ? '<span class="text-danger">' + errorCopyright + '</span><br/>' : '');
                $('#errRobots').append(errorRobots && !$('#errRobots').text().includes(errorRobots) ? '<span class="text-danger">' + errorRobots + '</span><br/>' : '');
                $('#errGoogleBot').append(errorGoogleBot && !$('#errGoogleBot').text().includes(errorGoogleBot) ? '<span class="text-danger">' + errorGoogleBot + '</span><br/>' : '');
                $('#errGoogleBotNews').append(errorGoogleBotNews && !$('#errGoogleBotNews').text().includes(errorGoogleBotNews) ? '<span class="text-danger">' + errorGoogleBotNews + '</span><br/>' : '');
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

    /* favicon */
    $(document).on('submit', '#formFavicon', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('favicon.update') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $("#pageloader").fadeOut();
                $(".btn .fa-spinner").hide();
                $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                if (res.code == 200) {
                    $('#formFavicon')[0].reset();
                    $('#faviconModal').modal('hide');
                    window.location = "{{ route('setting') }}";
                    return Toast.fire({
                        icon: "success",
                        title: '<b class="text-success">Success</b>',
                        text: "success update data!",
                    });
                }
            },
            error: function(err) {
                let error = err.responseJSON;
                let errorFavicon = error.errors.favicon;
                $('#errFavicon').append(errorFavicon && !$('#errFavicon').text().includes(errorFavicon) ? '<span class="text-danger">' + errorFavicon + '</span><br/>' : '');
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

    /* image */
    $(document).on('submit', '#formImage', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('image.update') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $("#pageloader").fadeOut();
                $(".btn .fa-spinner").hide();
                $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                if (res.code == 200) {
                    $('#formImage')[0].reset();
                    $('#ImageModal').modal('hide');
                    window.location = "{{ route('setting') }}";
                    return Toast.fire({
                        icon: "success",
                        title: '<b class="text-success">Success</b>',
                        text: "success update data!",
                    });
                    return Toast.fire({
                        icon: "error",
                        title: '<b class="text-danger">Unprocessable Content</b>',
                        text: "unable to be followed due to semantic errors.",
                    });
                }
            },
            error: function(err) {
                let error = err.responseJSON;
                let errorImage = error.errors.image;
                $('#errImage').append(errorImage && !$('#errImage').text().includes(errorImage) ? '<span class="text-danger">' + errorImage + '</span><br/>' : '');
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
</script>

@endsection