@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-newspaper"></i> Blog</h1>
    <a href="{{ route('/') }}" class="d-none d-sm-inline-block btn btn-sm btn-secoundary shadow-sm"><i class="fas fa-globe-asia fa-sm text-white-50"></i> Goto Website</a>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a class="btn btn-primary font-weight-bold" href="{{ route('blog.create') }}" title="Create Data">Create</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Writter</th>
                        <th class="text-center">Views</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Writter</th>
                        <th class="text-center">Views</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $row)
                    <tr>
                        <td class="text-center">{{ $loop->iteration}}. </td>
                        <td>{{ $row->title }}</td>
                        <td class="text-center">{{ $row->category_id }}</td>
                        <td class="text-center">{{ $row->name }}</td>
                        <td class="text-center">{{ $row->id }}</td>
                        <td class="text-center">{{ $row->date_post }}</td>
                        <td class="text-center">
                            <a class="btn-circle btn-sm btn-dark mt-1 mb-1" href="{{ route('blog.edit', encrypt($row->id)) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn-circle btn-sm btn-dark mt-1 mb-1" id="deleteData" href="" data-id="{{ $row->id }}" title="Delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* Delete Data */
        $(document).on('click', '#deleteData', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            console.log(id);
            if (confirm('Are you sure to delete it?')) {
                $.ajax({
                    url: "{{ route('blog.delete') }}",
                    method: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(res) {
                        if (res.code == 200) {
                            $('.table').load(location.href + ' .table');
                            return Toast.fire({
                                icon: "error",
                                title: '<b class="text-success">Success</b>',
                                text: "you won't be able to revert this!",
                            });
                        }
                    }
                });
            }
        });
    });
</script>
@endsection