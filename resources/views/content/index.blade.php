@extends('layouts.front')

@section('content')

<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                @foreach ($blog as $row)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>{{ $row->title }}</title>
                            <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>

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

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</main>

@endsection