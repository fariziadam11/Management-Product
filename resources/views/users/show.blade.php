@extends('layouts.app')

@section('page_heading', 'User Details')

@section('page_actions')
<div class="btn-group">
    @can('edit users')
    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> Edit User
    </a>
    @endcan
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <!-- User card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle mb-3" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=ffffff&size=200" alt="{{ $user->name }}" width="150" height="150">
                        <h4>{{ $user->name }}</h4>
                        <div class="text-muted">{{ $user->email }}</div>
                        @if($user->role)
                            <span class="badge bg-info">{{ $user->role->name }}</span>
                        @else
                            <span class="badge bg-secondary">No Role</span>
                        @endif
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>

                    <div class="list-group list-group-flush small">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-6 text-muted">User ID:</div>
                                <div class="col-6">{{ $user->id }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-6 text-muted">UUID:</div>
                                <div class="col-6">{{ $user->uuid }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-6 text-muted">Created:</div>
                                <div class="col-6">{{ $user->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-6 text-muted">Last Updated:</div>
                                <div class="col-6">{{ $user->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-6 text-muted">Last Login:</div>
                                <div class="col-6">
                                    @if($user->last_login_at)
                                        {{ \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y H:i') }}
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Activity card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    @if(count($user->audits) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Action</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->audits->take(10) as $audit)
                                        <tr>
                                            <td>{{ $audit->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <span class="badge {{ $audit->event == 'created' ? 'bg-success' : ($audit->event == 'updated' ? 'bg-primary' : 'bg-danger') }}">
                                                    {{ ucfirst($audit->event) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($audit->event == 'updated')
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($audit->getModified() as $attribute => $change)
                                                            <li>
                                                                <strong>{{ ucfirst($attribute) }}</strong>:
                                                                @if(is_array($change['old']) || is_array($change['new']))
                                                                    Changed
                                                                @else
                                                                    {{ $change['old'] }} → {{ $change['new'] }}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ ucfirst($audit->event) }} {{ class_basename($audit->auditable_type) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('audits.model', ['type' => 'users', 'id' => $user->id]) }}" class="btn btn-sm btn-outline-primary">
                                View All Activity
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> No activity records found for this user.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Reviews</h6>
                </div>
                <div class="card-body">
                    @if(count($user->reviews) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->reviews->take(5) as $review)
                                        <tr>
                                            <td>{{ $review->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('products.show', $review->product_id) }}">
                                                    {{ $review->product->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="text-warning">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td>{{ Str::limit($review->comment, 50) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(count($user->reviews) > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('reviews.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-outline-primary">
                                    View All Reviews
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> No reviews submitted by this user.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
