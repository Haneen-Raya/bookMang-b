@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font">Create New Book</h1>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- عنوان الكتاب -->
        <div class="mb-3">
            <label for="title" class="form-label" style="color: rgb(7, 19, 85);">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <!-- محتوى الكتاب -->
        <div class="mb-3">
            <label for="body" class="form-label" style="color: rgb(7, 19, 85);">Body</label>
            <textarea name="body" id="body" rows="4" class="form-control" required></textarea>
        </div>

        <!-- صورة الغلاف -->
        <div class="mb-3">
            <label for="cover" class="form-label" style="color: rgb(7, 19, 85);">Cover Image</label>
            <input type="file" name="cover" id="cover" class="form-control" required>
        </div>

        <!-- الصور الإضافية -->
        <div class="mb-3">
            <label for="images" class="form-label" style="color: rgb(7, 19, 85);">Additional Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>

        <!-- اختيار المؤلف -->
        <div class="mb-3">
            <label for="author_id" class="form-label" style="color: rgb(7, 19, 85);">Author</label>
            <select name="author_id" id="author_id" class="form-control">
                <option value="">Select an Author (Optional)</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- اختيار الأصناف (Checkboxes ذهبية) -->
        <div class="mb-3">
            <label for="categories" class="form-label" style="color: rgb(7, 19, 85);">Categories</label>
            <div class="form-check">
            @foreach ($categories as $category)
    <div class="mb-2">
        <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" class="form-check-input">
        <label for="category_{{ $category->id }}" class="form-check-label" style="color: goldenrod;">
            {{ $category->name }}
        </label>
    </div>
@endforeach

            </div>
        </div>

        <!-- زر الإرسال -->
        <button type="submit" class="btn btn-light" style="background-color: #F5DEB3; color: #8B4513;">Create Book</button>
    </form>
</div>
@endsection
