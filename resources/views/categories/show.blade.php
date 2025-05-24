@extends('layouts.app')

@section('page_heading', 'Category Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $category->name }}</h6>
                    <div>
                        <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }} me-2">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge {{ $category->published_at ? 'bg-info' : 'bg-warning' }} me-2">
                            {{ $category->published_at ? 'Published' : 'Draft' }}
                        </span>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold">Description</h6>
                        <p>{{ $category->description ?: 'No description provided.' }}</p>
                    </div>

                    @if(!empty($category->metadata))
                    <div class="mb-4">
                        <h6 class="fw-bold">Metadata</h6>
                        <pre class="bg-light p-3 rounded"><code>{{ json_encode($category->metadata, JSON_PRETTY_PRINT) }}</code></pre>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Created</h6>
                                <p>{{ $category->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Last Updated</h6>
                                <p>{{ $category->updated_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Published Date</h6>
                                <p>{{ $category->published_at ? $category->published_at->format('F d, Y \a\t h:i A') : 'Not published (Draft)' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Products in this Category</h6>
                                <p>{{ $category->products()->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products in this Category -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Products in this Category</h6>
                    <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Product
                    </a>
                </div>
                <div class="card-body">
                    @if($category->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Rating</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products as $product)
                                    <tr>
                                        <td class="text-center" style="width: 80px;">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 50px; max-width: 50px;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-image text-secondary"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" class="fw-bold text-primary">
                                                {{ $product->name }}
                                            </a>
                                            <div class="small text-muted">
                                                SKU: {{ $product->sku ?? 'N/A' }}
                                            </div>
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
                                        <td>
                                            @if($product->reviews_count > 0)
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= round($product->average_rating))
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @else
                                                                <i class="bi bi-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="small text-muted">({{ $product->reviews_count }})</span>
                                                </div>
                                            @else
                                                <span class="text-muted">No reviews</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($category->products()->count() > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="btn btn-outline-primary">
                                    View All Products in this Category
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            No products have been added to this category yet.
                            <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="alert-link">Add your first product</a>.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Category Audit History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Audit History</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Changes</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category->audits()->with('user')->latest()->take(5)->get() as $audit)
                                <tr>
                                    <td>
                                        @if($audit->user)
                                            <div class="d-flex align-items-center">
                                                <img class="rounded-circle me-2" src="https://ui-avatars.com/api/?name={{ urlencode($audit->user->name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $audit->user->name }}" width="24" height="24">
                                                {{ $audit->user->name }}
                                            </div>
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($audit->event == 'created')
                                            <span class="badge bg-success">Created</span>
                                        @elseif($audit->event == 'updated')
                                            <span class="badge bg-info">Updated</span>
                                        @elseif($audit->event == 'deleted')
                                            <span class="badge bg-danger">Deleted</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $audit->event }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($audit->new_values))
                                            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#auditDetails{{ $audit->id }}" aria-expanded="false">
                                                View Changes
                                            </button>
                                            <div class="collapse mt-2" id="auditDetails{{ $audit->id }}">
                                                <div class="card card-body">
                                                    <dl class="row mb-0">
                                                        @foreach($audit->new_values as $key => $value)
                                                            <dt class="col-sm-4">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                                            <dd class="col-sm-8">
                                                                @if(is_array($value))
                                                                    {{ json_encode($value) }}
                                                                @elseif(is_bool($value))
                                                                    {{ $value ? 'Yes' : 'No' }}
                                                                @else
                                                                    {{ $value }}
                                                                @endif
                                                            </dd>
                                                        @endforeach
                                                    </dl>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">No changes recorded</span>
                                        @endif
                                    </td>
                                    <td>{{ $audit->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No audit records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($category->audits()->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('audits.model', ['type' => 'category', 'id' => $category->id]) }}" class="btn btn-outline-primary btn-sm">
                                View All Audit History
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
