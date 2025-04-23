@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font text-center">{{ $book->title }}</h1>

    <!-- بطاقة الكتاب -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <!-- صورة الغلاف -->
                <div class="card-img-top text-center" style="height: 300px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Image" class="img-fluid" style="height: 100%; width: auto; object-fit: cover;">
                </div>
                <!-- محتوى البطاقة -->
                <div class="card-body" style="background-color: rgb(236, 216, 191);">
                    <p class="card-text" style="color: rgb(7, 19, 85);">{{ $book->body }}</p>

                    <!-- اسم المؤلف -->
                    <p><strong>Author:</strong> <span style="color: rgb(7, 19, 85);">{{ $book->author->name }}</span></p>

                    <!-- الأصناف -->
                    <p><strong>Categories:</strong>
                        @foreach ($book->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- الصور الإضافية -->
    @if ($book->images->count() > 0)
    <div class="mt-5">
        <h3 class="bubble-font text-center">Additional Images</h3>
        <div class="row">
            @foreach ($book->images as $image)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div style="height: 150px; overflow: hidden;">
                        <img src="{{ asset('storage/images/' . $image->images) }}" alt="Additional Image" class="img-fluid" style="height: 100%; width: auto; object-fit: cover;">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- أزرار التحكم -->
</div>
<div class="text-center mt-4">
    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513; margin-right: 10px;">Edit</a>
    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513;">Delete</button>
    </form>
    <a href="{{ url()->previous() }}" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513; margin-left: 10px;">Back</a>
</div>
<p>



</p>
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

    .badge {
        margin-right: 5px;
        font-size: 0.9rem;
    }

    .card-img-top img, .card img {
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .card-img-top img:hover, .card img:hover {
        transform: scale(1.1);
        filter: brightness(90%);
    }
</style>
@endsection
