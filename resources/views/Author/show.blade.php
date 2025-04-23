@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4" style="color: hsl(25, 73.00%, 34.90%); font-size: 2.5rem; font-weight: bold;">Authors</h1>

    <div class="text-center mb-3">
        <a href="/authors/create" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513;">Add New Author</a>
    </div>

    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="card" style="background-color: #FFFFFF; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #8B4513;">{{ $author->name }}</h5>
                    <p class="card-text" style="color: #8B4513;">Email: {{ $author->email }}</p>
                    <div class="text-center">

                    <a href="{{ route('authors.edit', $author->id) }}" class="action-btn btn-sm">Update</a>
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-sm">Delete</button>

                    </form>
                    <a href="{{ url()->previous() }}" style="text-decoration: none;">
                        <button type="button" style="font-size: 1rem; padding: 0.4rem 1rem; background-color: #ddd; color: #333; border: none; border-radius: 5px;">Back</button>
                    </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>

    /* أزرار التعديل والعرض والحذف */
    .action-btn {
        background-color:rgb(236, 216, 191);
        color:rgb(7, 19, 85);
        border: 1px solid #ddd;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .action-btn:hover {
        background-color: #ddd;
        color: #333;
    }
</style>
@endsection
