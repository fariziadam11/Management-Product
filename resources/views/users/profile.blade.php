@extends('layouts.app')

@section('page_heading', 'User Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card -->
            <div class="card mb-4 mb-xl-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
                </div>
                <div class="card-body text-center">
                    <!-- Profile picture image -->
                    <img class="img-account-profile rounded-circle mb-2" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=ffffff&size=150" alt="{{ $user->name }}" width="150" height="150">
                    <!-- Profile picture help block -->
                    <div class="small font-italic text-muted mb-4">{{ $user->name }}</div>
                    <!-- Profile picture upload button -->
                    <button class="btn btn-primary" type="button">Upload new image</button>
                </div>
            </div>

            <!-- Role information card -->
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Role Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-muted">Current Role</div>
                        <div class="h5">
                            @if($user->role)
                                <span class="badge bg-primary">{{ $user->role->name }}</span>
                            @else
                                <span class="badge bg-secondary">No Role Assigned</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-muted">Account Created</div>
                        <div>{{ $user->created_at->format('F d, Y') }}</div>
                    </div>
                    <div>
                        <div class="small text-muted">Last Updated</div>
                        <div>{{ $user->updated_at->format('F d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <!-- Account details card -->
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Account Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Form Group (name) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Full Name</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Enter your full name" value="{{ $user->name }}">
                        </div>

                        <!-- Form Group (email address) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email address</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ $user->email }}">
                        </div>

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="phone">Phone number</label>
                                <input class="form-control" id="phone" name="phone" type="tel" placeholder="Enter your phone number" value="{{ $user->phone ?? '' }}">
                            </div>
                            <!-- Form Group (birthday) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="birthday">Birthday</label>
                                <input class="form-control" id="birthday" name="birthday" type="date" placeholder="Enter your birthday" value="{{ $user->birthday ?? '' }}">
                            </div>
                        </div>

                        <!-- Save changes button -->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>

            <!-- Security card -->
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Security</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.password', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Form Group (current password) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="current_password">Current Password</label>
                            <input class="form-control" id="current_password" name="current_password" type="password" placeholder="Enter current password">
                        </div>

                        <!-- Form Group (new password) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="password">New Password</label>
                            <input class="form-control" id="password" name="password" type="password" placeholder="Enter new password">
                        </div>

                        <!-- Form Group (confirm password) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="password_confirmation">Confirm Password</label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm new password">
                        </div>

                        <!-- Save changes button -->
                        <button class="btn btn-primary" type="submit">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Your Recent Reviews</h6>
                </div>
                <div class="card-body">
                    @if(count($user->reviews) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Rating</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->reviews as $review)
                                    <tr>
                                        <td>{{ $review->product->name }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        <td>{{ $review->title }}</td>
                                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">You haven't written any reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
