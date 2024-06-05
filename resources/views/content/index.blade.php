@extends('layouts.front')

@section('content')

<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                @foreach ($data as $row)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        @if ($row->image === null || $row->image == "")
                        <img width="100%" height="200" src="https://placehold.co/200x200?text=Image+Not+Found" class="img-thumbnail img-fluid mx-auto d-block" alt="...">
                        @else
                        <img width="100%" height="200" src="{{ asset('uploads/thumb/' . $row->image) }}" class="img-thumbnail img-fluid mx-auto d-block" alt="cover image">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ Str::limit($row->title, 32) }}</h5>
                            <p class="card-text">{{ Str::limit($row->description, 82) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ route('blog.detail', $row->slug) }}">Detail</a>
                                </div>
                                <small class="text-muted">{{ date('Y-m-d', strtotime($row->date_post)) }}</small>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
            {{ $data->links('vendor.pagination.custom') }}
        </div>
    </div>

</main>

@endsection