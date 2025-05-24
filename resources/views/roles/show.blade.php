@extends('layouts.app')

@section('page_heading', 'Role Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $role->name }}</h6>
                    <div>
                        <span class="badge {{ $role->is_active ? 'bg-success' : 'bg-danger' }} me-2">
                            {{ $role->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold">Description</h6>
                        <p>{{ $role->description ?: 'No description provided.' }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Permissions</h6>
                        @if($role->permissions && is_array($role->permissions) && count($role->permissions) > 0)
                            <div class="row">
                                @foreach($role->permissions as $permission)
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <span>{{ ucwords(str_replace('.', ' ', $permission)) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No permissions assigned.</p>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Created</h6>
                                <p>{{ $role->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Last Updated</h6>
                                <p>{{ $role->updated_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Last Used</h6>
                                <p>{{ $role->last_used_at ? $role->last_used_at->format('F d, Y \a\t h:i A') : 'Never' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Users with this Role</h6>
                                <p>{{ $role->users()->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users with this Role -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Users with this Role</h6>
                </div>
                <div class="card-body">
                    @if($role->users()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users()->paginate(10) as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="rounded-circle me-2" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $user->name }}" width="24" height="24">
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if(auth()->user()->hasAnyRole('admin', 'manager', 'editor'))
                                                <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm" title="View User">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled title="Access restricted to Admin, Manager, or Editor">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            {{ $role->users()->paginate(10)->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            No users are currently assigned to this role.
                        </div>
                    @endif
                </div>
            </div>


            <!-- Role Audit History -->
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
                                @forelse($role->audits()->with('user')->latest()->take(10)->get() as $audit)
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

                    @if($role->audits()->count() > 10)
                        <div class="text-center mt-3">
                            <a href="{{ route('audits.model', ['type' => 'role', 'id' => $role->id]) }}" class="btn btn-outline-primary btn-sm">
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
