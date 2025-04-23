@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font text-center">Edit Book</h1>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- تعديل عنوان الكتاب -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title) }}" required>
        </div>

        <!-- تعديل محتوى الكتاب -->
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea name="body" id="body" rows="4" class="form-control" required>{{ old('body', $book->body) }}</textarea>
        </div>

        <!-- تعديل صورة الغلاف -->
        <div class="mb-3">
            <label for="cover" class="form-label">Cover Image</label>
            <input type="file" name="cover" id="cover" class="form-control">
            @if ($book->cover)
            <div class="mt-2 text-center">
                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Image" style="width: 150px; height: auto; object-fit: cover; border-radius: 5px;">
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
            @endif
        </div>

        <!-- إضافة صور إضافية -->
        <div class="mb-3">
            <label for="images" class="form-label">Additional Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>

        <!-- اختيار المؤلف -->
        <div class="mb-3">
            <label for="author_id" class="form-label">Author</label>
            <select name="author_id" id="author_id" class="form-control" required>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- اختيار الأصناف -->
        <div class="mb-3">
    <label for="categories" class="form-label">Categories</label>
    <div class="form-check" style="display: flex; flex-direction: column; gap: 10px;">
        @foreach ($categories as $category)
        <div class="form-check">
            <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}"
                class="form-check-input"
                {{ old('categories') && in_array($category->id, old('categories')) ? 'checked' : ($book->categories->contains($category->id) ? 'checked' : '') }}>
            <label for="category_{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
        </div>
        @endforeach
    </div>
</div>

        <!-- زر التحديث -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Update Book</button>
        </div>
    </form>

    <!-- زر العودة إلى الخلف -->
    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<style>
    .btn-primary {
        border-radius: 5px;
        font-size: 16px;
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary {
        font-size: 14px;
        color: #fff;
    }

    img {
        transition: transform 0.3s ease;
    }

    img:hover {
        transform: scale(1.05);
    }

    .form-check-label {
        margin-left: 10px;
    }
</style>
@endsection

