@extends('layouts.front')

@section('content')
<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">

            <h3 class="pb-4 mb-4 font-italic border-bottom">
                Latest Blog
            </h3>
            <div class="row">
                @foreach ($blog_latest as $row)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>{{ $row->title }}</title>
                            <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>

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
                @foreach ($blog_trending as $row)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>{{ $row->title }}</title>
                            <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>

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