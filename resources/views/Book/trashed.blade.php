@extends('Dash') {{-- أو اسم ملف الـ Layout الرئيسي لديك --}}

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font text-center mb-4">Trashed Books</h1>

    {{-- عرض رسائل النجاح والخطأ --}}
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- نهاية عرض الرسائل --}}

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th> {{-- عرض اسم المؤلف --}}
                    <th>Deleted At</th> {{-- تاريخ الحذف المؤقت --}}
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        {{-- عرض اسم المؤلف - تأكد من جلب العلاقة في المتحكم باستخدام with('author') --}}
                        <td>{{ $book->author?->name ?? 'N/A' }}</td> {{-- استخدام Nullsafe Operator --}}
                        <td>{{ $book->deleted_at->format('Y-m-d H:i') }}</td> {{-- تنسيق تاريخ الحذف --}}
                        <td class="text-center">
                            <!-- زر استعادة الكتاب (أخضر) -->
                            <form action="{{ route('books.restore', $book->id) }}" method="POST" class="d-inline-block me-1">
                                @csrf
                                @method('PATCH') {{-- مهم: استخدام PATCH للمسار --}}
                                <button type="submit" class="btn btn-success btn-sm" title="Restore Book">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                            </form>

                            <!-- زر الحذف النهائي (أحمر/بيج) -->
                            <form action="{{ route('books.forceDelete', $book->id) }}" method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Are you sure you want to permanently delete this book? This action cannot be undone!');">
                                @csrf
                                @method('DELETE') {{-- مهم: استخدام DELETE للمسار --}}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Permanently"> {{-- أو btn-beige --}}
                                     <i class="fas fa-trash-alt"></i> Delete Forever
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted fst-italic">No trashed books found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- روابط التصنيف -->
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>

    <!-- زر العودة -->
    <div class="text-center mt-4">
        <a href="{{ route('books.index') }}" class="btn btn-primary"> {{-- أو btn-beige --}}
             <i class="fas fa-arrow-left"></i> Back to Books List
        </a>
    </div>

</div>
@endsection

{{-- اختياري: إضافة CSS لـ btn-beige إذا كنت تستخدمه --}}
@push('styles')
<style>
    .btn-beige {
        color: #333;
        background-color: #f5f5dc;
        border-color: #dcd8c0;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }
    .btn-beige:hover {
        color: #000;
        background-color: #e4e4c8;
        border-color: #c8c4a8;
    }
    .bubble-font {
        font-weight: bold;
    }
</style>
@endpush
