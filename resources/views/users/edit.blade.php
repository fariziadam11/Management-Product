@extends('layouts.app')

@section('page_heading', 'Edit User')

@section('page_actions')
<a href="{{ route('users.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Back to Users
</a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Basic Information -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <small class="text-muted">(leave blank to keep current)</small></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday', $user->birthday ? $user->birthday->format('Y-m-d') : '') }}">
                                    @error('birthday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="statusActive" value="1" {{ old('is_active', $user->is_active) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="statusInactive" value="0" {{ old('is_active', $user->is_active) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $user->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Activity -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>IP Address</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($audits as $audit)
                                    <tr>
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
                                            {{ class_basename($audit->auditable_type) }}
                                        </td>
                                        <td>{{ $audit->ip_address }}</td>
                                        <td>{{ $audit->created_at->format('M d, Y H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No activity found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password strength validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        passwordInput.addEventListener('input', function() {
            if (this.value) {
                validatePassword();
            } else {
                const existingFeedback = passwordInput.parentNode.querySelector('.password-strength');
                if (existingFeedback) {
                    passwordInput.parentNode.removeChild(existingFeedback);
                }
            }
        });

        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value && this.value) {
                validatePasswordMatch();
            } else {
                const existingFeedback = confirmPasswordInput.parentNode.querySelector('.password-match');
                if (existingFeedback) {
                    confirmPasswordInput.parentNode.removeChild(existingFeedback);
                }
            }
        });

        function validatePassword() {
            const password = passwordInput.value;
            let strength = 0;

            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 1;

            const feedbackElement = document.createElement('div');
            feedbackElement.className = 'password-strength mt-1';

            switch(strength) {
                case 0:
                case 1:
                    feedbackElement.innerHTML = '<span class="text-danger">Very Weak</span>';
                    break;
                case 2:
                    feedbackElement.innerHTML = '<span class="text-warning">Weak</span>';
                    break;
                case 3:
                    feedbackElement.innerHTML = '<span class="text-info">Medium</span>';
                    break;
                case 4:
                    feedbackElement.innerHTML = '<span class="text-primary">Strong</span>';
                    break;
                case 5:
                    feedbackElement.innerHTML = '<span class="text-success">Very Strong</span>';
                    break;
            }

            const existingFeedback = passwordInput.parentNode.querySelector('.password-strength');
            if (existingFeedback) {
                passwordInput.parentNode.removeChild(existingFeedback);
            }

            passwordInput.parentNode.appendChild(feedbackElement);
        }

        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            const feedbackElement = document.createElement('div');
            feedbackElement.className = 'password-match mt-1';

            if (confirmPassword === '') {
                feedbackElement.innerHTML = '';
            } else if (password === confirmPassword) {
                feedbackElement.innerHTML = '<span class="text-success">Passwords match</span>';
            } else {
                feedbackElement.innerHTML = '<span class="text-danger">Passwords do not match</span>';
            }

            const existingFeedback = confirmPasswordInput.parentNode.querySelector('.password-match');
            if (existingFeedback) {
                confirmPasswordInput.parentNode.removeChild(existingFeedback);
            }

            confirmPasswordInput.parentNode.appendChild(feedbackElement);
        }
    });
</script>
@endsection
