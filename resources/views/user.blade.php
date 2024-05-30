@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-users"></i> Data Users</h1>
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
                        <th class="text-center">Email</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $row)
                    <tr>
                        <td class="text-center">{{ $loop->iteration}}. </td>
                        <td>{{ $row->email}}</td>
                        <td>{{ $row->name}}</td>
                        <td class="text-center">
                            <a class="btn-circle btn-sm btn-dark mt-1 mb-1" id="editData" data-toggle="modal" data-target="#editModal" data-id="{{ $row->id }}" data-name="{{ $row->name }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn-circle btn-sm btn-dark mt-1 mb-1" id="deleteBtn" data-id="{{ $row->id }}" title="Delete"><i class="fas fa-trash"></i></a>
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
                        <label for="email" class="col-form-label font-weight-bold">Email:</label>
                        <input type="text" class="form-control" name="email" />
                        <div id="errAddEmail"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label font-weight-bold">Full Name:</label>
                        <input type="text" class="form-control" name="name" />
                        <div id="errAddName"></div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label font-weight-bold">Password:</label>
                        <input type="text" class="form-control" name="password" />
                        <div id="errAddPassword"></div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm" class="col-form-label font-weight-bold">Password Confirm:</label>
                        <input type="text" class="form-control" name="password_confirm" />
                        <div id="errAddPasswordConfirm"></div>
                    </div>
                    <div class="form-group">
                        <label for="picture" class="col-form-label font-weight-bold">Picture:</label>
                        <input type="file" class="form-control" name="picture" />
                        <div id="errAddPicture"></div>
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
                        <input type="hidden" name="id" id="id" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label font-weight-bold">Email:</label>
                        <input type="text" class="form-control" name="email" />
                        <div id="errEditEmail"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label font-weight-bold">Full Name:</label>
                        <input type="text" class="form-control" name="name" />
                        <div id="errEditName"></div>
                    </div>
                    <div class="form-group">
                        <label for="picture" class="col-form-label font-weight-bold">Picture:</label>
                        <input type="file" class="form-control" name="picture" />
                        <div id="errEditPicture"></div>
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
                url: "{{ route('users.store') }}",
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {
                    $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    $('#addForm')[0].reset();
                    window.location = "{{ route('users') }}";
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
                    $('#errAddEmail').append(errorEmail && !$('#errAddEmail').text().includes(errorEmail) ? '<span class="text-danger">' + errorEmail + '</span><br/>' : '');
                    $('#errAddName').append(errorName && !$('#errAddName').text().includes(errorName) ? '<span class="text-danger">' + errorName + '</span><br/>' : '');
                    $('#errAddPassword').append(errorPassword && !$('#errAddPassword').text().includes(errorPassword) ? '<span class="text-danger">' + errorPassword + '</span><br/>' : '');
                    $('#errAddPasswordConfirm').append(errorPasswordConfirm && !$('#errAddPasswordConfirm').text().includes(errorPasswordConfirm) ? '<span class="text-danger">' + errorPasswordConfirm + '</span><br/>' : '');
                    $("#pageloader").fadeOut();
                    $(".btn .fa-spinner").hide();
                    $(".btn .text-loader").html('<i class="fas fa-save"></i> Submit');
                    return Toast.fire({
                        icon: "error",
                        title: '<b class="text-danger">Unprocessable Content:</b> unable to be followed due to semantic errors.'
                    });
                }
            })
        })

        /* Edit Data */
        $(document).on('click', '#editData', function() {
            let id = $(this).data('id');
            let tag = $(this).data('tag');
            $('#id').val(id);
            $('#tag').val(tag);
            $(document).on('submit', '#editForm', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('users.update') }}",
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
                        let errorTag = error.errors.tag;
                        $('#errEditTag').append(errorTag && !$('#errEditTag').text().includes(errorTag) ? '<span class="text-danger">' + errorTag + '</span><br/>' : '');
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
                    url: "{{ route('users.delete') }}",
                    method: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(res) {
                        if (res.code == 200) {
                            $('.table').load(location.href + ' .table');
                            return Toast.fire({
                                icon: "success",
                                title: '<b class="text-success">Success:</b> update data success.',
                            });
                        }
                    }
                });
            }
        });
    });
</script>

@endsection