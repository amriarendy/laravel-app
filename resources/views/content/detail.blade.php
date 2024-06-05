@extends('layouts.front')

@section('content')
<main role="main" class="container">
    <div class="row">
        <div class="col-md-8 blog-main">
            @if ($data->image === null || $data->image == "")
            <div class="text-center my-3" style="max-height: 300px; margin: -30px -30px 20px -30px; overflow: hidden;">
                <img width="600" height="400" src="https://placehold.co/700x400?text=Image+Not+Found" class="img-thumbnail img-fluid mx-auto d-block" alt="...">
            </div>
            @else
            <div class="text-center my-3" style="max-height: 300px; margin: -30px -30px 20px -30px; overflow: hidden;">
                <img width="600" height="400" src="{{ asset('uploads/thumb/' . $data->image) }}" class="img-thumbnail img-fluid mx-auto d-block" alt="cover image">
            </div>
            @endif
            
            <div class="my-3 border-bottom"></div>
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
                @if ($keywords)
                @foreach ($keywords as $row)
                <a class="btn btn-outline-primary" href="#">{{ $row->tag }}</a>
                @endforeach
                @endif
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
                    <li><a href="{{ route('blog.category', $row->slug) }}">{{ strtoupper($row->category) }}</a></li>
                    @endforeach
                </ol>
            </div>

            <div class="p-4">
                <h4 class="font-italic">Tranding Today</h4>
                <ol class="list-unstyled">
                    @foreach ($tranding as $row)
                    <li><a href="{{ route('blog.detail', $row->slug) }}">{{ $row->title }}</a></li>
                    @endforeach
                </ol>
            </div>
        </aside><!-- /.blog-sidebar -->

    </div><!-- /.row -->

</main><!-- /.container -->

@endsection