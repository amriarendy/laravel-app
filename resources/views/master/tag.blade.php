@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-hashtag"></i> Tag</h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#addModal" title="Tambah Data">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tag</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tag</th>
            <th class="text-center">Aksi</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach ($data as $row)
          <tr>
            <td class="text-center">{{ $loop->iteration}}. </td>
            <td>{{ $row->tag}}</td>
            <td class="text-center">
              <a class="btn btn-sm btn-warning mt-1 mb-1" id="editData" data-toggle="modal" data-target="#editModal" data-id="{{ $row->id }}" data-tag="{{ $row->tag }}" title="Edit"><i class="fas fa-edit"></i></a>
              <a class="btn btn-sm btn-danger mt-1 mb-1" id="deleteBtn" data-id="{{ $row->id }}" title="Delete"><i class="fas fa-trash"></i></a>
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
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="addModalLabel">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" action="" id="addForm" name="addForm" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label for="tag" class="col-form-label font-weight-bold">Tag:</label>
            <input type="text" class="form-control" name="tag" />
            <div id="errAddTag"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="addBtn" class="btn btn-primary"> <i class="fas fa-spinner fa-spin" style="display:none;"></i>
            <span class="text-loader">Submit</span></button>
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
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="editModalLabel">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" action="" id="editForm" name="editForm" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            @csrf
            <input type="hidden" name="id" id="id" required>
          </div>
          <div class="form-group">
            <label for="tag" class="col-form-label font-weight-bold">Tag:</label>
            <input type="text" class="form-control" id="tag" name="tag" required>
            <div id="errEditTag"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="editBtn" class="btn btn-primary"> <i class="fas fa-spinner fa-spin" style="display:none;"></i>
            <span class="text-loader">Submit</span></button>
      </form>
    </div>
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
        url: "{{ route('tag.store') }}",
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(res) {
          $("#pageloader").fadeOut();
          $(".btn .fa-spinner").hide();
          $(".btn .text-loader").html("Submit");
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
          let errorTag = error.errors.tag;
          $('#errAddTag').append(errorTag && !$('#errAddTag').text().includes(errorTag) ? '<span class="text-danger">' + errorTag + '</span><br/>' : '');
          $("#pageloader").fadeOut();
          $(".btn .fa-spinner").hide();
          $(".btn .text-loader").html("Submit");
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
      let tag = $(this).data('tag');
      $('#id').val(id);
      $('#tag').val(tag);
      $(document).on('submit', '#editForm', function(e) {
        e.preventDefault();
        $.ajax({
          url: "{{ route('tag.update') }}",
          method: 'POST',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
          $("#pageloader").fadeOut();
          $(".btn .fa-spinner").hide();
          $(".btn .text-loader").html("Submit");
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
          $(".btn .text-loader").html("Submit");
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
          url: "{{ route('tag.delete') }}",
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