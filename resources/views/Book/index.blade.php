@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font">Books List</h1>
    <div class="text-center mb-3">
        <a href="/books/create" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513;">Add New Book</a>
    </div>
    <div class="row">
        @foreach ($books as $book)
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <!-- صورة الغلاف -->
                <div class="card-img-top" style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Image" class="img-fluid" style="height: 100%; width: auto; object-fit: cover;">
                </div>
                <!-- محتوى البطاقة -->
                <div class="card-body" style="background-color: rgb(236, 216, 191);">
                    <h5 class="card-title" style="color: rgb(7, 19, 85);">{{ $book->title }}</h5>
                    <p class="card-text" style="color: rgb(7, 19, 85);">{{ Str::limit($book->body, 120) }}</p>
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513;">Read More</a>
                </div>
                <!-- تاريخ الإنشاء -->
                <div class="card-footer text-muted text-center" style="background-color: rgb(226, 204, 173);">
                    <small>Created on: {{ $book->created_at->format('d M Y') }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- رابط صفحات التبديل (Pagination) -->
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ $books->previousPageUrl() }}" class="btn btn-pagination">Previous</a>
        <a href="{{ $books->nextPageUrl() }}" class="btn btn-pagination">Next</a>
    </div>
</div>

<style>
    @font-face {
        font-family: 'Bubble';
        src: url('path/to/bubble-font.ttf');
    }

    .bubble-font {
        font-family: 'Bubble', sans-serif;
        font-size: 2.5rem;
        color: hsl(25, 76.00%, 24.50%);
        text-align: center;
    }

    .btn-pagination {
        background-color: #F5DEB3;
        color: #8B4513;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        margin: 0 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-pagination:hover {
        background-color: #e3c29b;
        color: #6b3710;
    }

    .card-footer {
        font-size: 0.9rem;
        border-top: 1px solid #ddd;
    }

    .card img {
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .card img:hover {
        transform: scale(1.05);
        filter: brightness(90%);
    }

    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>
@endsection
