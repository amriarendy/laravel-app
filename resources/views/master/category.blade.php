@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-code-branch"></i> Category</h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#addModal" title="Create Data">Create</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $row)
                    <tr>
                        <td class="text-center">{{ $loop->iteration}}. </td>
                        <td class="text-center">{{ $row->category}}</td>
                        <td class="text-center">
                            <a class="btn-circle btn-sm btn-dark mt-1 mb-1" id="editData" data-toggle="modal" data-target="#editModal" data-id="{{ $row->id }}" data-category="{{ $row->category }}" data-slug="{{ $row->slug }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn-circle btn-sm btn-dark mt-1 mb-1" id="deleteBtn" href="" data-id="{{ $row->id }}" title="Delete"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" action="" id="addForm" name="addForm" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="addModalLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="category" class="col-form-label font-weight-bold">Category:</label>
                        <input type="text" class="form-control title" name="category">
                        <div id="errAddCategory"></div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="slug">Slug <span style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input class="checkboxSlug" type="checkbox" />
                                </span>
                            </div>
                            <input type="text" class="form-control slug" name="slug" maxlength="100" readonly>
                        </div>
                        <div id="errAddSlug"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold closeBtn" data-dismiss="modal">Close</button>
                    <button type="submit" id="addBtn" class="btn btn-primary font-weight-bold"> <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                        <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ./Modal Add -->

<!-- Modal Edit -->
<div class="modal fade" id="editModal" aria-labelledby="editModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" action="" id="editForm" name="editForm" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        @csrf
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-form-label font-weight-bold">Category:</label>
                        <input type="text" class="form-control title" id="category" name="category">
                        <div id="errEditCategory"></div>
                    </div>
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
                        <div id="errEditSlug"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold closeBtn" data-dismiss="modal">Close</button>
                    <button type="submit" id="editBtn" class="btn btn-primary font-weight-bold"> <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                        <span class="text-loader"><i class="fas fa-save"></i> Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ./Modal Edit -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* Create Data */
    $(document).ready(function() {
        $(document).on('submit', '#addForm', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('category.store') }}",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {
                    $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    if (res.code == 200) {
                        $('#addModal').modal('hide');
                        $('#addForm')[0].reset();
                        $('.table').load(location.href + ' .table');
                        return Toast.fire({
                            icon: "success",
                            title: '<b class="text-success">Success:</b> create data success.',
                        });
                    }
                },
                error: function(err) {
                    let error = err.responseJSON;
                    let errorCategory = error.errors.category;
                    let errorSlug = error.errors.slug;
                    console.log(errorSlug);
                    $('#errAddCategory').append(errorCategory && !$('#errAddCategory').text().includes(errorCategory) ? '<span class="text-danger">' + errorCategory + '</span><br/>' : '');
                    $('#errAddSlug').append(errorSlug && !$('#errAddSlug').text().includes(errorSlug) ? '<span class="text-danger">' + errorSlug + '</span><br/>' : '');
                    $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    return Toast.fire({
                        icon: "error",
                        title: '<b class="text-danger">Unprocessable Content:</b> unable to be followed due to semantic errors.',
                    });
                }
            });
        })

        /* Edit Data */
        $(document).on('click', '#editData', function() {
            let id = $(this).data('id');
            let category = $(this).data('category');
            let slug = $(this).data('slug');
            $('#id').val(id);
            $('#category').val(category);
            $('#slug').val(slug);
            $(document).on('submit', '#editForm', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('category.update') }}",
                    method: 'POST',
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
                            $('.table').load(location.href + ' .table');
                            return Toast.fire({
                                icon: "success",
                                title: '<b class="text-success">Success:</b> update data success.',
                            });
                        }
                    },
                    error: function(err) {
                        let error = err.responseJSON;
                        let errorCategory = error.errors.category;
                        let errorSlug = error.errors.slug;
                        console.log(errorSlug);
                        $('#errEditCategory').append(errorCategory && !$('#errEditCategory').text().includes(errorCategory) ? '<span class="text-danger">' + errorCategory + '</span><br/>' : '');
                        $('#errEditSlug').append(errorSlug && !$('#errEditSlug').text().includes(errorSlug) ? '<span class="text-danger">' + errorSlug + '</span><br/>' : '');
                        $("#pageloader").fadeOut();
                        $(".btn .fa-spinner").hide();
                        $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                        return Toast.fire({
                            icon: "error",
                            title: '<b class="text-danger">Unprocessable Content:</b> unable to be followed due to semantic errors.',
                        });
                    }
                });
            });
        });

        /* Delete Data */
        $(document).on('click', '#deleteBtn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            if (confirm('Apakah yakin untuk menghapus data?')) {
                $.ajax({
                    url: "{{ route('category.delete') }}",
                    method: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(res) {
                        if (res.code == 200) {
                            $('.table').load(location.href + ' .table');
                            return Toast.fire({
                                icon: "success",
                                title: '<b class="text-success">Success:</b> delete data success.',
                            });
                        }
                    }
                });
            }
        });
    });
</script>

@endsection