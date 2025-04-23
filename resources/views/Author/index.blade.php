@extends('Dash')

@section('content')
<div class="container mt-4">
<h1 class="bubble-font">Authors List</h1>

    <div class="text-center mb-3">
        <a href="/authors/create" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513;">Add New Author</a>
    </div>

    <table class="table table-striped" style="background-color: #FFFFFF;">
        <thead>
            <tr>
                <th style="color: #8B4513;">#</th>
                <th style="color: #8B4513;">Name</th>
                <th style="color: #8B4513;">Email</th>
                <th style="color: #8B4513;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
            <tr>
                <td style="color: #8B4513;">{{ $author->id }}</td>
                <td style="color: #8B4513;">{{ $author->name }}</td>
                <td style="color: #8B4513;">{{ $author->email }}</td>
                <td>
                    <a href="{{ route('authors.edit', $author->id) }}" class="action-btn btn-sm">Update</a>
                    <a href="{{ route('authors.show', $author->id) }}" class="action-btn btn-sm">Show</a>
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        <a href="{{ $authors->previousPageUrl() }}" class="btn btn-pagination">Previous</a>
        <a href="{{ $authors->nextPageUrl() }}" class="btn btn-pagination">Next</a>
    </div>
</div>

<style>@font-face {
        font-family: 'Bubble';
        src: url('path/to/bubble-font.ttf');
    }

    .bubble-font {
        font-family: 'Bubble', sans-serif;
        font-size: 2.5rem;
        color: hsl(25, 76.00%, 24.50%);
        text-align: center;
    }
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

    /* أزرار السابق والتالي */
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
</style>
@endsection
