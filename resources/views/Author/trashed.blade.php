@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font text-center mb-4">Trashed Authors</h1>

    {{-- عرض رسائل النجاح والخطأ --}}
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- هذه هي الرسالة التي ستظهر عند محاولة حذف مؤلف له كتب --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }} {{-- <-- هنا ستظهر رسالة "لا يمكن الحذف..." --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- نهاية عرض الرسائل --}}


    <!-- عرض قائمة المؤلفين المحذوفين -->
    <div class="table-responsive">
        <table class="table table-striped table-hover"> {{-- تم الحفاظ على table-hover --}}
            {{-- تمت إزالة table-dark من هنا --}}
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($authors as $author)
                    <tr>
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->email }}</td>
                        <td class="text-center">
                            <!-- زر استعادة المؤلف (أخضر) -->
                            <form action="{{ route('authors.restore', $author->id) }}" method="POST" class="d-inline-block me-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm" title="Restore Author">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                            </form>

                            <!-- زر الحذف النهائي (بيج) -->
                            <form action="{{ route('authors.forceDelete', $author->id) }}" method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Are you sure you want to permanently delete this author? This action cannot be undone!');">
                                @csrf
                                @method('DELETE')
                                {{-- ******* تم تغيير الكلاس إلى btn-beige ******* --}}
                                <button type="submit" class="btn btn-beige btn-sm" title="Delete Permanently">
                                     <i class="fas fa-trash-alt"></i> Delete Forever
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted fst-italic">No trashed authors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- روابط التصنيف -->
    <div class="d-flex justify-content-center mt-4">
        {{ $authors->links() }}
    </div>

    <!-- زر العودة (بيج) -->
    <div class="text-center mt-4">
        {{-- ******* تم تغيير الكلاس إلى btn-beige ******* --}}
        <a href="{{ route('authors.index') }}" class="btn btn-beige">
             <i class="fas fa-arrow-left"></i> Back to Authors List
        </a>
    </div>

</div>
@endsection

{{-- هام: تأكد من أن لديك تعريف CSS لـ btn-beige --}}
@push('styles')
<style>
    .btn-beige {
        color: #333; /* لون النص */
        background-color: #f5f5dc; /* لون الخلفية البيج */
        border-color: #dcd8c0; /* لون الحدود */
        padding: 0.25rem 0.5rem; /* تنسيق حجم الزر ليتناسب مع btn-sm */
        font-size: 0.875rem;    /* تنسيق حجم الخط ليتناسب مع btn-sm */
        border-radius: 0.2rem;  /* تنسيق حواف الزر */
    }
    .btn-beige:hover {
        color: #000;
        background-color: #e4e4c8; /* لون الخلفية عند المرور بالماوس */
        border-color: #c8c4a8;
    }
    /* يمكنك إزالة هذا إذا كان معرفاً بشكل عام */
    .bubble-font {
        font-weight: bold;
    }
</style>
@endpush
