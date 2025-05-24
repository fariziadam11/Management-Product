@extends('layouts.app')

@section('page_heading', 'Edit Category')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Category: {{ $category->name }}</h6>
                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                            <div class="form-text">Inactive categories won't appear in product dropdowns</div>
                        </div>

                        <div class="mb-3">
                            <label for="metadata" class="form-label">Metadata (JSON)</label>
                            <textarea class="form-control @error('metadata') is-invalid @enderror" id="metadata" name="metadata" rows="3">{{ old('metadata', json_encode($category->metadata ?? new stdClass(), JSON_PRETTY_PRINT)) }}</textarea>
                            @error('metadata')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at"
                                value="{{ old('published_at', $category->published_at ? $category->published_at->format('Y-m-d\TH:i') : '') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty to save as draft</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category Usage Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Category Usage Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Created</label>
                                <p>{{ $category->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated</label>
                                <p>{{ $category->updated_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Products in this Category</label>
                                <p>{{ $category->products()->count() }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="ms-2 badge {{ $category->published_at ? 'bg-info' : 'bg-warning' }}">
                                        {{ $category->published_at ? 'Published' : 'Draft' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($category->products()->count() > 0)
                    <div class="mt-3">
                        <h6 class="fw-bold">Recent Products in this Category</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products()->latest()->limit(5)->get() as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('products.edit', $product) }}">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>
                                            @if($product->stock > 10)
                                                <span class="badge bg-success">{{ $product->stock }} in stock</span>
                                            @elseif($product->stock > 0)
                                                <span class="badge bg-warning">{{ $product->stock }} left</span>
                                            @else
                                                <span class="badge bg-danger">Out of stock</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach

                                    @if($category->products()->count() > 5)
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}">View all {{ $category->products()->count() }} products</a>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format the metadata JSON when the form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            const metadataField = document.getElementById('metadata');
            try {
                // Parse and then stringify to format the JSON
                const formattedJson = JSON.stringify(JSON.parse(metadataField.value), null, 2);
                metadataField.value = formattedJson;
            } catch (e) {
                // If it's not valid JSON, leave it as is - validation will catch it
            }
        });
    });
</script>
@endpush
@endsection
