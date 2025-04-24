@extends('Dash') {{-- Or your main layout file --}}

@push('styles')
<style>
    /* Beige Button Style (if not already defined globally) */
    .btn-beige {
        color: #333;
        background-color: #f5f5dc; /* Beige background */
        border-color: #dcdcc3;
    }
    .btn-beige:hover {
        color: #333;
        background-color: #e9e9ce; /* Lighter beige on hover */
        border-color: #d4d4b9;
    }

    /* Beige Table Styles */
    .table-beige {
        border-color: #dcdcc3; /* Beige border for the table */
    }
    .table-beige thead th {
        background-color: #e9e9ce; /* Slightly darker beige for header */
        color: #5a5a4d; /* Darker text color for contrast */
        border-color: #dcdcc3;
    }
    .table-beige tbody tr {
        background-color: #fdfdf1; /* Very light beige for body rows */
    }
    /* Style for striped tables with beige */
    .table-striped.table-beige > tbody > tr:nth-of-type(odd) > * {
        background-color: #f5f5dc; /* Standard beige for odd rows */
         color: #333;
    }
     .table-striped.table-beige > tbody > tr:nth-of-type(even) > * {
        background-color: #fdfdf1; /* Lighter beige for even rows */
         color: #333;
    }
    /* Hover effect for beige table */
     .table-hover.table-beige > tbody > tr:hover > * {
        background-color: #e9e9ce; /* Use the header beige for hover */
         color: #333;
    }

    /* Ensure buttons in the same cell have some space */
    form.d-inline-block + form.d-inline-block {
        margin-left: 5px;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    {{-- Title in English --}}
    <h1 class="bubble-font text-center">Trashed Categories</h1>

    {{-- Session Messages (Displayed in English if set correctly in Controller) --}}
    @if(session('message'))
        <div class="alert {{ session('message_type') == 'error' ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Trashed Categories List -->
    <div class="table-responsive">
        {{-- Add the 'table-beige' class --}}
        <table class="table table-striped table-hover table-beige">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    {{-- Add other relevant columns if needed --}}
                    {{-- <th>Description</th> --}}
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        {{-- <td>{{ $category->description ?? '-' }}</td> --}}
                        <td>{{ $category->deleted_at ? $category->deleted_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>
                            <!-- Restore Button (Green) -->
                            <form action="{{ route('categories.restore', $category->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PATCH') {{-- Or POST if your route uses POST --}}
                                <button type="submit" class="btn btn-success btn-sm" title="Restore Category">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                            </form>

                            <!-- Force Delete Button (Beige) -->
                            <form action="{{ route('categories.forceDelete', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to permanently delete this category? This action cannot be undone!');"> {{-- English Confirmation --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-beige btn-sm" title="Delete Permanently">
                                     <i class="fas fa-times-circle"></i> Delete Permanently
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        {{-- Adjust colspan to match the number of columns --}}
                        <td colspan="4" class="text-center text-muted">No trashed categories found.</td> {{-- English Text --}}
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    @if ($categories->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
    </div>
    @endif

    <!-- Back Button (Grey/Secondary) -->
    <div class="text-center mt-4 mb-4">
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
           <i class="fas fa-arrow-left"></i> Back to Categories List {{-- English Text --}}
        </a>
    </div>

</div>
@endsection

@push('scripts')
{{-- Optional JavaScript for alert dismissal --}}
<script>
    var alertList = document.querySelectorAll('.alert');
    alertList.forEach(function (alert) {
      new bootstrap.Alert(alert);
    });
</script>
@endpush
