@extends('Dash')

@section('content')
<div class="container mt-4">
    <h1 class="bubble-font text-center">Trashed Authors</h1>

    <!-- عرض قائمة المؤلفين المحذوفين -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($authors as $author)
                    <tr>
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->email }}</td>
                        <td>
                            <!-- زر استعادة المؤلف -->
                            <form action="{{ route('authors.restore', $author->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PATCH') {{-- تأكد أن المسار في web.php يستخدم patch --}}
                                <button type="submit" class="btn btn-success btn-sm" title="Restore Author">
                                    <i class="fas fa-undo"></i> استعادة
                                </button>
                            </form>

                            <!-- زر الحذف النهائي (بيج) -->
                            <form action="{{ route('authors.forceDelete', $author->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المؤلف بشكل نهائي؟ لا يمكن التراجع عن هذا الإجراء!');">
                                @csrf
                                @method('DELETE') {{-- تأكد أن المسار في web.php يستخدم delete --}}
                                <button type="submit" class="btn btn-beige btn-sm" title="Delete Permanently">
                                     <i class="fas fa-times-circle"></i> حذف نهائي
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No trashed authors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- زر العودة -->
    <div class="text-center mt-4">
        <a href="{{ route('authors.index') }}" class="btn btn-primary">Back to Authors</a>
    </div>

    <!-- روابط التصنيف -->
    <div class="mt-3">
        {{ $authors->links() }}
    </div>
</div>
@endsection
