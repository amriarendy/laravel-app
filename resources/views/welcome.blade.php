@extends('layouts.front')

@section('content')
<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">

            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Latest Blog
            </h3>
            <div class="row">
                @foreach ($latest as $row)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        @if ($row->image === null || $row->image == "")
                        <img width="100%" height="200" src="https://placehold.co/200x200?text=Image+Not+Found" class="img-thumbnail img-fluid mx-auto d-block" alt="...">
                        @else
                        <img width="100%" height="200" src="{{ asset('uploads/thumb/' . $row->image) }}" class="img-thumbnail img-fluid mx-auto d-block" alt="cover image">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ Str::limit($row->title, 32) }}</h5>
                            <p class="card-text text-justify">{{ Str::limit($row->description, 82) }}</p>
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

            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Trending Today
            </h3>
            <div class="row">
                @foreach ($tranding as $row)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        @if ($row->image === null || $row->image == "")
                        <img width="100%" height="200" src="https://placehold.co/200x200?text=Image+Not+Found" class="img-thumbnail img-fluid mx-auto d-block" alt="...">
                        @else
                        <img width="100%" height="200" src="{{ asset('uploads/thumb/' . $row->image) }}" class="img-thumbnail img-fluid mx-auto d-block" alt="cover image">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ Str::limit($row->title, 32) }}</h5>
                            <p class="card-text text-justify">{{ Str::limit($row->description, 82) }}</p>
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

        </div>
    </div>

</main>

@endsection