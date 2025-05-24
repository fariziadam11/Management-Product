@extends('layouts.app')

@section('page_heading', 'Review Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Review #{{ $review->id }}</h6>
                    <div>
                        <a href="{{ route('reviews.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Back to Reviews
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
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="badge {{ $review->status == 'approved' ? 'bg-success' : ($review->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($review->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Content -->
                    <div class="mb-4">
                        <h5 class="fw-bold">{{ $review->title }}</h5>
                        <p class="text-muted mb-0">{{ $review->content }}</p>
                    </div>

                    <hr>

                    <!-- Reviewer Information -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Reviewer Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle me-2" src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer_name) }}&background=4e73df&color=ffffff&size=32" alt="{{ $review->reviewer_name }}" width="32" height="32">
                                        <div>
                                            <div>{{ $review->reviewer_name }}</div>
                                            @if($review->reviewer_email)
                                                <div class="small text-muted">{{ $review->reviewer_email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="small text-muted">Submitted on</div>
                                    <div>{{ $review->created_at->format('F d, Y \a\t h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($review->attachment)
                    <div class="mb-4">
                        <h6 class="fw-bold">Attachments</h6>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-pdf text-danger me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <a href="{{ asset('storage/' . $review->attachment) }}" target="_blank" class="text-decoration-none">
                                    View Attachment
                                </a>
                                <div class="small text-muted">PDF Document</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($review->additional_data && count($review->additional_data) > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold">Additional Information</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    @foreach($review->additional_data as $key => $value)
                                    <tr>
                                        <th style="width: 30%;">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                        <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <div>
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </div>
                    <div>
                        @if($review->status == 'pending')
                            <form action="{{ route('reviews.update', $review) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Approve
                                </button>
                            </form>
                            <form action="{{ route('reviews.update', $review) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Reject
                                </button>
                            </form>
                        @elseif($review->status == 'approved')
                            <form action="{{ route('reviews.update', $review) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Reject
                                </button>
                            </form>
                        @elseif($review->status == 'rejected')
                            <form action="{{ route('reviews.update', $review) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Approve
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this review?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
