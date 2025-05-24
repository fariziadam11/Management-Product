@extends('layouts.app')

@section('page_heading', 'Export Data')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Export {{ ucfirst($type) }}</h6>
                    <div>
                        <a href="{{ route($type . '.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Back to {{ ucfirst($type) }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('export.process', ['type' => $type]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <!-- Export Format -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Export Format</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="format" id="format_csv" value="csv" checked>
                                                <label class="form-check-label w-100" for="format_csv">
                                                    <div class="mb-3">
                                                        <i class="bi bi-filetype-csv text-success" style="font-size: 2.5rem;"></i>
                                                    </div>
                                                    <h6>CSV</h6>
                                                    <p class="small text-muted mb-0">Comma-separated values</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="format" id="format_xlsx" value="xlsx">
                                                <label class="form-check-label w-100" for="format_xlsx">
                                                    <div class="mb-3">
                                                        <i class="bi bi-file-earmark-excel text-primary" style="font-size: 2.5rem;"></i>
                                                    </div>
                                                    <h6>Excel</h6>
                                                    <p class="small text-muted mb-0">Microsoft Excel format</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="format" id="format_json" value="json">
                                                <label class="form-check-label w-100" for="format_json">
                                                    <div class="mb-3">
                                                        <i class="bi bi-filetype-json text-warning" style="font-size: 2.5rem;"></i>
                                                    </div>
                                                    <h6>JSON</h6>
                                                    <p class="small text-muted mb-0">JavaScript Object Notation</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fields to Export -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Fields to Export</label>
                            <div class="row">
                                @if($type == 'users')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_email" value="email" checked>
                                            <label class="form-check-label" for="field_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_role" value="role_id" checked>
                                            <label class="form-check-label" for="field_role">Role</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_active" value="is_active" checked>
                                            <label class="form-check-label" for="field_active">Active Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @elseif($type == 'products')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_category" value="category_id" checked>
                                            <label class="form-check-label" for="field_category">Category</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_price" value="price" checked>
                                            <label class="form-check-label" for="field_price">Price</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_stock" value="stock" checked>
                                            <label class="form-check-label" for="field_stock">Stock</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_description" value="description">
                                            <label class="form-check-label" for="field_description">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_featured" value="is_featured">
                                            <label class="form-check-label" for="field_featured">Featured Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @elseif($type == 'roles')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_description" value="description" checked>
                                            <label class="form-check-label" for="field_description">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_permissions" value="permissions">
                                            <label class="form-check-label" for="field_permissions">Permissions</label>
                                        </div>
                                    </div>
                                @elseif($type == 'categories')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_description" value="description">
                                            <label class="form-check-label" for="field_description">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_uuid" value="uuid">
                                            <label class="form-check-label" for="field_uuid">UUID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_active" value="is_active" checked>
                                            <label class="form-check-label" for="field_active">Active Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @elseif($type == 'reviews')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_product" value="product_id" checked>
                                            <label class="form-check-label" for="field_product">Product</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_user" value="user_id" checked>
                                            <label class="form-check-label" for="field_user">User</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_rating" value="rating" checked>
                                            <label class="form-check-label" for="field_rating">Rating</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_title" value="title" checked>
                                            <label class="form-check-label" for="field_title">Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_content" value="content">
                                            <label class="form-check-label" for="field_content">Content</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_status" value="status" checked>
                                            <label class="form-check-label" for="field_status">Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Filters</label>
                            <div class="card">
                                <div class="card-body">
                                    @if($type == 'users')
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="filter_role" class="form-label">Role</label>
                                                <select class="form-select" id="filter_role" name="filters[role_id]">
                                                    <option value="">All Roles</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="filter_status" class="form-label">Status</label>
                                                <select class="form-select" id="filter_status" name="filters[is_active]">
                                                    <option value="">All Statuses</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($type == 'products')
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="filter_category" class="form-label">Category</label>
                                                <select class="form-select" id="filter_category" name="filters[category_id]">
                                                    <option value="">All Categories</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="filter_featured" class="form-label">Featured</label>
                                                <select class="form-select" id="filter_featured" name="filters[is_featured]">
                                                    <option value="">All Products</option>
                                                    <option value="1">Featured Only</option>
                                                    <option value="0">Non-Featured Only</option>
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($type == 'categories')
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="filter_category" class="form-label">Category</label>
                                                <select class="form-select" id="filter_category" name="filters[id]">
                                                    <option value="">All Categories</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="filter_status" class="form-label">Status</label>
                                                <select class="form-select" id="filter_status" name="filters[is_active]">
                                                    <option value="">All Statuses</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($type == 'reviews')
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="filter_product" class="form-label">Product</label>
                                                <select class="form-select" id="filter_product" name="filters[product_id]">
                                                    <option value="">All Products</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="filter_rating" class="form-label">Rating</label>
                                                <select class="form-select" id="filter_rating" name="filters[rating]">
                                                    <option value="">All Ratings</option>
                                                    <option value="5">5 Stars</option>
                                                    <option value="4">4 Stars</option>
                                                    <option value="3">3 Stars</option>
                                                    <option value="2">2 Stars</option>
                                                    <option value="1">1 Star</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="filter_status" class="form-label">Status</label>
                                                <select class="form-select" id="filter_status" name="filters[status]">
                                                    <option value="">All Statuses</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="rejected">Rejected</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route($type . '.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-download me-1"></i> Export Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Previous Exports -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Previous Exports</h6>
                </div>
                <div class="card-body">
                    @if(count($previousExports) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Format</th>
                                        <th>Records</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($previousExports as $export)
                                        <tr>
                                            <td>{{ $export->created_at->format('M d, Y H:i') }}</td>
                                            <td>{{ ucfirst($export->type) }}</td>
                                            <td>
                                                <span class="badge {{ $export->format == 'csv' ? 'bg-success' : ($export->format == 'xlsx' ? 'bg-primary' : 'bg-warning') }}">
                                                    {{ strtoupper($export->format) }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($export->record_count) }}</td>
                                            <td>
                                                <a href="{{ route('export.download', $export->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> No previous exports found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card.shadow-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }

    .form-check-label {
        cursor: pointer;
    }
</style>
@endsection
