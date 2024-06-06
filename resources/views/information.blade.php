@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Information</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="font-weight-bold text-dark">Information</h6>
            </div>
            <div class="card-body">
            <p><b>MASTER CATEGORIES</b><br>Master categories feature is used to create categories on the blog page and create new menus on the navbar.<br><br><b>MASTER TAG</b><br>Master tag feature is used to add keywords for SEO in the meta data header.</p><p><b>BLOG</b><br>Blog page to create blog content. Required inputs are title, slug, category, posting date, description, and body content.</p><p><b>BODY CONTENT FEATURES</b><br><img src="http://127.0.0.1:8000/summernote.png" style="width: 100%;"></p><p>1. Style&nbsp;<br>2. Bold<br>3. Underline<br>4. Remove Font Style<br>5. Font Family<br>6. Recent Color<br>7. Unordered List<br>8. Ordered List<br>9. Paragraph<br>10. Table<br>11. Link<br>12. Picture: (upload video from local, and link)<br>13. Video: (embed video: youtube etc)<br>14. Full Screen<br>15. Code View<br>16. Help</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="font-weight-bold text-dark">Donate Information</h6>
            </div>
            <div class="card-body">
            <h3 style="text-align: center; "><b>☕Donate Me</b></h3><p style="text-align: center; "><img src="http://127.0.0.1:8000/saweria.png" style="width: 25%;"></p><p style="text-align: center; "><br><a href="https://saweria.co/amriarendy/" class="btn btn-dark btn-icon-split btn-small" target="_blank"><span class="icon text-white-50"><i class="fas fa-coffee"></i></span><span class="text">Buy Me Coffee</span></a></p>
            </div>
        </div>
    </div>
</div>

@endsection