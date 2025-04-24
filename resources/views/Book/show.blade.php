@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font text-center">{{ $book->title }}</h1>

    <!-- Book Card -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <!-- Cover Image -->
                <div class="card-img-top text-center" style="height: 300px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Image" class="img-fluid" style="height: 100%; width: auto; object-fit: cover;">
                </div>
                <!-- Card Content -->
                <div class="card-body" style="background-color: rgb(236, 216, 191);">
                    <p class="card-text" style="color: rgb(7, 19, 85);">{{ $book->body }}</p>

                    <!-- Author -->
                    <p><strong>Author:</strong>
                        <span style="color: rgb(7, 19, 85);">
                         {{ $book->author?->name ?? 'N/A' }}
                        </span>
                    </p>

                    <!-- Categories -->
                    <p><strong>Categories:</strong>
                        @forelse ($book->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                        @empty
                            <span class="text-muted">No categories assigned.</span>
                        @endforelse
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Images -->
    @if ($book->images->count() > 0)
    <div class="mt-5">
        <h3 class="bubble-font text-center">Additional Images</h3>
        <div class="row">
            @foreach ($book->images as $image)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div style="height: 150px; overflow: hidden;">
                        <img src="{{ asset('storage/images/' . $image->images) }}" alt="Additional Image {{ $loop->iteration }}" class="img-fluid" style="height: 100%; width: auto; object-fit: cover;">
                    </div>
                    
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Control Buttons -->
    <div class="text-center mt-4 mb-4"> {{-- Added mb-4 for spacing before potential footer --}}
        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513; margin-right: 10px;">Edit</a>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this book?');"> {{-- Added confirmation --}}
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513;">Delete</button>
        </form>
        <a href="{{ url()->previous() }}" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513; margin-left: 10px;">Back</a>
    </div>

</div> <!-- End of container -->

{{-- It's better practice to move styles to a CSS file or a @push('styles') section --}}
<style>
    @font-face {
        font-family: 'Bubble';
        /* Ensure the path is correct relative to your public directory or CSS file */
        src: url('/fonts/bubble-font.ttf'); /* Example path - adjust as needed */
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
        transform: scale(1.05); /* Slightly reduced scale for hover */
        filter: brightness(90%);
    }
</style>
@endsection
