@extends('layouts.app')

@section('page_heading', 'Edit Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Review #{{ $review->id }}</h6>
                    <div>
                        <a href="{{ route('reviews.show', $review) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Back to Review
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Product Information -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 me-3">
                                @if($review->product && $review->product->image)
                                    <img src="{{ asset('storage/' . $review->product->image) }}" alt="{{ $review->product->name }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="bi bi-image text-secondary" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-1">
                                    <a href="{{ route('products.show', $review->product_id) }}" class="text-decoration-none">
                                        {{ $review->product ? $review->product->name : 'Unknown Product' }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <form action="{{ route('reviews.update', $review) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Product Selection -->
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product</label>
                            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $review->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rating -->
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating-input">
                                <div class="d-flex">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="rating{{ $i }}">
                                                <i class="bi {{ $i <= old('rating', $review->rating) ? 'bi-star-fill' : 'bi-star' }} text-warning"></i>
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $review->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Review</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5" required>{{ old('content', $review->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reviewer Name -->
                        <div class="mb-3">
                            <label for="reviewer_name" class="form-label">Reviewer Name</label>
                            <input type="text" class="form-control @error('reviewer_name') is-invalid @enderror" id="reviewer_name" name="reviewer_name" value="{{ old('reviewer_name', $review->reviewer_name) }}" required>
                            @error('reviewer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reviewer Email -->
                        <div class="mb-3">
                            <label for="reviewer_email" class="form-label">Reviewer Email</label>
                            <input type="email" class="form-control @error('reviewer_email') is-invalid @enderror" id="reviewer_email" name="reviewer_email" value="{{ old('reviewer_email', $review->reviewer_email) }}">
                            @error('reviewer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status', $review->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Attachment -->
                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment</label>
                            @if($review->attachment)
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                        <div>
                                            <a href="{{ asset('storage/' . $review->attachment) }}" target="_blank" class="text-decoration-none">
                                                Current Attachment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="remove_attachment" name="remove_attachment" value="1">
                                    <label class="form-check-label" for="remove_attachment">
                                        Remove current attachment
                                    </label>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                            <div class="form-text">Upload a new attachment (PDF only, max 500KB)</div>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reviews.show', $review) }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize star rating
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        const ratingLabels = document.querySelectorAll('.rating-input label');

        ratingInputs.forEach((input, index) => {
            input.addEventListener('change', function() {
                // Reset all stars
                ratingLabels.forEach((label, i) => {
                    if (i <= index) {
                        label.innerHTML = '<i class="bi bi-star-fill text-warning"></i>';
                    } else {
                        label.innerHTML = '<i class="bi bi-star text-warning"></i>';
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
