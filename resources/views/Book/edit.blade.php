@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font text-center mb-4">Edit Book: {{ $book->title }}</h1>

    {{-- Display Success/Error Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- End Display Messages --}}

    <div class="row">
        {{-- العمود الأيسر للصور وإجراءات الحذف --}}
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card shadow-sm">
                <div class="card-header">Book Media</div>
                <div class="card-body">
                    {{-- عرض صورة الغلاف الحالية --}}
                    @if ($book->cover)
                        <div class="mb-3 text-center">
                            <p class="mb-1 fw-bold">Current Cover:</p>
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Current Cover" class="img-thumbnail" style="max-width: 150px; height: auto;">
                        </div>
                        <hr>
                    @endif

                    {{-- عرض الصور الإضافية الحالية وأزرار الحذف --}}
                    <p class="mb-2 fw-bold">Additional Images:</p>
                    @if($book->images->isNotEmpty())
                        @foreach($book->images as $image)
                            <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                <img src="{{ asset('storage/images/' . $image->images) }}" class="img-thumbnail me-2" style="max-height: 80px; max-width: 120px; object-fit: cover;" alt="Image {{ $loop->iteration }}">
                                <form action="{{ route('destroyBookSpecificImage', ['id' => $book->id, 'image_id' => $image->id]) }}" method="POST" class="d-inline ms-auto" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Delete this image">*</button>
                                </form>
                            </div>
                        @endforeach

                        <form action="{{ route('books.destroyAllImages', $book->id) }}"
                  method="POST"
                  class="mt-3"
                  onsubmit="return confirm('Are you sure you want to delete ALL additional images?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-all">Delete All Additional Images</button>
            </form>
        @else
           <p class="text-muted">No additional images found.</p>
        @endif
                </div>
            </div>
        </div>

        {{-- العمود الأيمن لنموذج التعديل --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">Edit Details</div>
                <div class="card-body">
                    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- حقول النموذج --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $book->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Body <span class="text-danger">*</span></label>
                            <textarea name="body" id="body" rows="5" class="form-control @error('body') is-invalid @enderror" required>{{ old('body', $book->body) }}</textarea>
                             @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author_id" class="form-label">Author <span class="text-danger">*</span></label>
                            <select name="author_id" id="author_id" class="form-select @error('author_id') is-invalid @enderror" required>
                                <option value="" disabled {{ old('author_id', $book->author_id) ? '' : 'selected' }}>Select Author</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                             @error('author_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categories</label>
                            <div class="form-check-container p-2 border rounded">
                                @forelse ($categories as $category)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}"
                                        class="form-check-input @error('categories') is-invalid @enderror"
                                        {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) || (!old('categories') && $book->categories->contains($category->id)) ? 'checked' : '' }}>
                                    <label for="category_{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
                                </div>
                                @empty
                                 <p class="text-muted">No categories available.</p>
                                @endforelse
                                @error('categories')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cover" class="form-label">Replace Cover Image (Optional)</label>
                            <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                             @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Add New Additional Images (Optional)</label>
                            <input type="file" name="images[]" id="images" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                            @error('images.*')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>

                        {{-- أزرار الإرسال والعودة --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> Update Book</button>
                            <a href="{{ route('books.index') }}" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* إعادة استخدام تنسيقات الأزرار البرتقالية من مثال المدونة */
    .btn-delete {
        background-color: transparent;
        border: none;
        color: #ff8c00; /* لون برتقالي */
        font-size: 24px; /* حجم الخط أكبر قليلاً ليبدو كعلامة '*' مميزة */
        line-height: 1;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s ease, transform 0.3s ease;
        padding: 0 5px; /* إضافة بعض الحشوة الأفقية */
    }
    .btn-delete:hover {
        color: #cc7000; /* لون برتقالي داكن عند التحويم */
        transform: scale(1.2); /* تكبير الزر قليلاً عند التحويم */
    }

    .btn-delete-all {
        background-color: transparent;
        border: 1px solid #ff8c00; /* إضافة إطار برتقالي */
        color: #ff8c00; /* لون برتقالي */
        font-size: 0.875rem; /* حجم الخط */
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease; /* تأثير التحويل */
        padding: 0.375rem 0.75rem; /* ضبط الحشوة */
        border-radius: 0.25rem; /* تدوير الحواف */
        display: inline-block; /* للسماح بالهامش */
        width: 100%; /* جعله يأخذ عرض العمود إذا لزم الأمر */
        text-align: center;
    }
    .btn-delete-all:hover {
        background-color: #ff8c00; /* لون برتقالي عند التحويم */
        color: #fff; /* لون النص عند التحويم */
    }

    /* تنسيقات أخرى مشابهة لمثال المدونة */
    .img-thumbnail {
        transition: transform 0.3s ease;
    }
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
    .form-check-container {
        max-height: 150px;
        overflow-y: auto;
    }
    .bubble-font {
        /* (يفترض أن يكون معرفًا في Dash أو أضفه هنا إذا لم يكن) */
        font-weight: bold; /* مثال */
    }
    /* تأكد من تحميل Font Awesome للـ icons في الأزرار */
</style>
@endpush

{{-- ملاحظة: هذا الكود لا يشمل jQuery أو Bootstrap 4 JS أو الكود الخاص بتحديث نص label الملفات
     لأن Bootstrap 5 يتعامل مع هذا بشكل مختلف أو قد لا يكون ضروريًا. --}}

@endsection
