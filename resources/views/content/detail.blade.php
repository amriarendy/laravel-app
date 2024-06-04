@extends('layouts.front')

@section('content')
<main role="main" class="container">
    <div class="row">
        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 border-bottom">
                {{ $data->category_id }}
            </h3>

            <div class="blog-post">
                <h2 class="blog-post-title">{{ $data->title }}</h2>
                <p class="blog-post-meta">{{ date('Y-m-d', strtotime($data->date_post)) }} <a href="#">{{ $data->name }}</a></p>
                <p>{!! $data->body !!}</p>
                @if ($files)
                @foreach ($files as $row)
                <li> <a href="{{ asset('/uploads/files/'.$row->file) }}" target="_blank"> <b>[Download File] - {{$row->file}}</b> </a> </li>
                @endforeach
                @endif
            </div>
            <!-- /.blog-post -->

            <nav class="blog-pagination">
                <a class="btn btn-outline-primary" href="#">Older</a>
                <a class="btn btn-outline-secondary disabled">Newer</a>
            </nav>

        </div><!-- /.blog-main -->

        <aside class="col-md-4 blog-sidebar">
            <div class="p-4 mb-3 bg-light rounded">
                <h4 class="font-italic">About</h4>
                <p class="mb-0">Saw you downtown singing the Blues. Watch you circle the drain. Why don't you let me stop by? Heavy is the head that <em>wears the crown</em>. Yes, we make angels cry, raining down on earth from up above.</p>
            </div>

            <div class="p-4">
                <h4 class="font-italic">Blog Categories</h4>
                <ol class="list-unstyled mb-0">
                    @foreach ($categories as $row)
                    <li><a href="{{ route('blog.category'), ['slug' => $row->slug] }}">{{ strtoupper($row->category) }}</a></li>
                    @endforeach
                </ol>
            </div>

            <div class="p-4">
                <h4 class="font-italic">Tranding Today</h4>
                <ol class="list-unstyled">
                    <li><a href="#">GitHub</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Facebook</a></li>
                </ol>
            </div>
        </aside><!-- /.blog-sidebar -->

    </div><!-- /.row -->

</main><!-- /.container -->

@endsection