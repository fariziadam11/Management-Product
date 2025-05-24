@extends('layouts.app')

@section('page_heading', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-1">Welcome, {{ Auth::user()->name }}!</h4>
                            <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('analytics.dashboard') }}" class="btn btn-primary me-2">
                                <i class="bi bi-graph-up me-1"></i> Analytics
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Add Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary text-white me-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="small font-weight-bold text-primary text-uppercase">Users</div>
                        </div>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">View All</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.create') }}">Add New</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('export.form', 'users') }}">Export</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['users'] }}</div>
                    <div class="text-xs text-success mt-2">
                        <i class="bi bi-arrow-up me-1"></i>
                        {{ isset($stats['user_growth']) ? $stats['user_growth'] : '0' }}% since last month
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-people me-1"></i> Manage Users
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-success text-white me-3">
                                <i class="bi bi-list-nested"></i>
                            </div>
                            <div class="small font-weight-bold text-success text-uppercase">Categories</div>
                        </div>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="{{ route('categories.index') }}">View All</a></li>
                                <li><a class="dropdown-item" href="{{ route('categories.create') }}">Add New</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('export.form', 'categories') }}">Export</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['categories'] }}</div>
                    <div class="text-xs text-muted mt-2">
                        <i class="bi bi-tag me-1"></i>
                        {{ isset($stats['active_categories']) ? $stats['active_categories'] : $stats['categories'] }} active
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-success w-100">
                        <i class="bi bi-list-nested me-1"></i> Manage Categories
                    </a>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info text-white me-3">
                                <i class="bi bi-box"></i>
                            </div>
                            <div class="small font-weight-bold text-info text-uppercase">Products</div>
                        </div>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="{{ route('products.index') }}">View All</a></li>
                                <li><a class="dropdown-item" href="{{ route('products.create') }}">Add New</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('export.form', 'products') }}">Export</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['products'] }}</div>
                    <div class="text-xs text-danger mt-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        {{ isset($stats['low_stock']) ? $stats['low_stock'] : '0' }} low stock
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-info w-100">
                        <i class="bi bi-box me-1"></i> Manage Products
                    </a>
                </div>
            </div>
        </div>

        <!-- Reviews Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-warning text-white me-3">
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="small font-weight-bold text-warning text-uppercase">Reviews</div>
                        </div>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="{{ route('reviews.index') }}">View All</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('export.form', 'reviews') }}">Export</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stats['reviews'] }}</div>
                    <div class="text-xs text-warning mt-2">
                        <i class="bi bi-clock me-1"></i>
                        {{ isset($stats['pending_reviews']) ? $stats['pending_reviews'] : '0' }} pending
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-warning w-100">
                        <i class="bi bi-star me-1"></i> Manage Reviews
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('products.create') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle bg-primary text-white mx-auto mb-3">
                                            <i class="bi bi-plus-circle"></i>
                                        </div>
                                        <h6 class="card-title mb-0">Add Product</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('categories.create') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle bg-success text-white mx-auto mb-3">
                                            <i class="bi bi-folder-plus"></i>
                                        </div>
                                        <h6 class="card-title mb-0">Add Category</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('users.create') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle bg-info text-white mx-auto mb-3">
                                            <i class="bi bi-person-plus"></i>
                                        </div>
                                        <h6 class="card-title mb-0">Add User</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('analytics.dashboard') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle bg-warning text-white mx-auto mb-3">
                                            <i class="bi bi-graph-up"></i>
                                        </div>
                                        <h6 class="card-title mb-0">View Analytics</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Products -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Products</h6>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(count($recentProducts) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentProducts as $product)
                                <div class="list-group-item px-0 py-3 border-0 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-image text-secondary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                                <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                                    {{ $product->stock > 10 ? 'In Stock' : ($product->stock > 0 ? 'Low Stock' : 'Out of Stock') }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="small text-muted">
                                                    <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
                                                    <span class="ms-2">Added {{ $product->created_at->diffForHumans() }}</span>
                                                </div>
                                                <span class="text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-end">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            No products found. <a href="{{ route('products.create') }}" class="alert-link">Add your first product</a>.
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-transparent py-2">
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-grid me-1"></i> View All Products
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Reviews</h6>
                    <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(count($recentReviews) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentReviews as $review)
                                <div class="list-group-item px-0 py-3 border-0 border-bottom">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <img class="rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer_name) }}&background=4e73df&color=ffffff&size=40" alt="{{ $review->reviewer_name }}" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">{{ $review->reviewer_name }}</h6>
                                                <span class="small text-muted">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star text-warning"></i>
                                                    @endif
                                                @endfor
                                                <span class="badge bg-{{ $review->status == 'approved' ? 'success' : ($review->status == 'pending' ? 'warning' : 'danger') }} ms-2">
                                                    {{ ucfirst($review->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <strong>{{ $review->title }}</strong>
                                        <p class="mb-1 text-muted">{{ Str::limit($review->content, 100) }}</p>
                                        <div class="small">Product: <a href="{{ route('products.show', $review->product_id) }}">{{ $review->product->name }}</a></div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            No reviews found yet.
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-transparent py-2">
                    <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-star me-1"></i> View All Reviews
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                    <a href="{{ route('audits.index') }}" class="btn btn-sm btn-primary">View All Audits</a>
                </div>
                <div class="card-body">
                    @if(count($recentAudits) > 0)
                        <div class="timeline">
                            @foreach($recentAudits as $audit)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $audit->event == 'created' ? 'success' : ($audit->event == 'updated' ? 'warning' : ($audit->event == 'deleted' ? 'danger' : 'info')) }}"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold">{{ ucfirst($audit->event) }} {{ class_basename($audit->auditable_type) }}</h6>
                                            <small class="text-muted">{{ $audit->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            @if($audit->user)
                                                <img class="rounded-circle me-2" src="https://ui-avatars.com/api/?name={{ urlencode($audit->user->name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $audit->user->name }}" width="24" height="24">
                                                <span>{{ $audit->user->name }}</span>
                                            @else
                                                <i class="bi bi-robot me-2"></i>
                                                <span>System</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <div class="small">
                                                <strong>{{ class_basename($audit->auditable_type) }}:</strong>
                                                @if($audit->auditable)
                                                    @if(method_exists($audit->auditable, 'getNameAttribute'))
                                                        {{ $audit->auditable->name }}
                                                    @elseif(property_exists($audit->auditable, 'name'))
                                                        {{ $audit->auditable->name }}
                                                    @elseif(property_exists($audit->auditable, 'title'))
                                                        {{ $audit->auditable->title }}
                                                    @else
                                                        ID: {{ $audit->auditable_id }}
                                                    @endif
                                                @else
                                                    ID: {{ $audit->auditable_id }} (deleted)
                                                @endif
                                            </div>

                                            @if($audit->event == 'updated' && !empty($audit->old_values) && !empty($audit->new_values))
                                                <div class="small mt-1">
                                                    <strong>Changed:</strong>
                                                    @foreach($audit->old_values as $key => $value)
                                                        @if(array_key_exists($key, $audit->new_values))
                                                            <span class="badge bg-light text-dark me-1">{{ $key }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <a href="{{ route('audits.show', $audit->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            No audit logs found yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Icon Circles */
    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 50%;
    }

    /* Timeline Styles */
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0.75rem;
        height: 100%;
        width: 2px;
        background-color: #e3e6f0;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-marker {
        position: absolute;
        top: 0.25rem;
        left: -1.5rem;
        height: 1rem;
        width: 1rem;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e3e6f0;
    }

    .timeline-content {
        padding: 1rem;
        background-color: #fff;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    /* Card hover effects */
    .card.shadow-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }

    .border-left-primary {
        border-left: 0.25rem solid var(--primary-color) !important;
    }
    .border-left-success {
        border-left: 0.25rem solid var(--success-color) !important;
    }
    .border-left-info {
        border-left: 0.25rem solid var(--info-color) !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid var(--warning-color) !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .fa-2x {
        font-size: 2rem;
    }
</style>
@endsection
