@extends('layouts.app')

@section('page_heading', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Role: {{ $role->name }}</h6>
                    <span class="badge {{ $role->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $role->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                            <div class="form-text">Inactive roles cannot be assigned to users</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Permissions</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_users_view" name="permissions[]" value="users.view"
                                                    {{ in_array('users.view', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_users_view">View Users</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_users_create" name="permissions[]" value="users.create"
                                                    {{ in_array('users.create', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_users_create">Create Users</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_users_edit" name="permissions[]" value="users.edit"
                                                    {{ in_array('users.edit', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_users_edit">Edit Users</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_users_delete" name="permissions[]" value="users.delete"
                                                    {{ in_array('users.delete', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_users_delete">Delete Users</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_products_view" name="permissions[]" value="products.view"
                                                    {{ in_array('products.view', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_products_view">View Products</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_products_create" name="permissions[]" value="products.create"
                                                    {{ in_array('products.create', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_products_create">Create Products</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_products_edit" name="permissions[]" value="products.edit"
                                                    {{ in_array('products.edit', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_products_edit">Edit Products</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_products_delete" name="permissions[]" value="products.delete"
                                                    {{ in_array('products.delete', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_products_delete">Delete Products</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_categories_manage" name="permissions[]" value="categories.manage"
                                                    {{ in_array('categories.manage', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_categories_manage">Manage Categories</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_reviews_manage" name="permissions[]" value="reviews.manage"
                                                    {{ in_array('reviews.manage', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_reviews_manage">Manage Reviews</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_reports_view" name="permissions[]" value="reports.view"
                                                    {{ in_array('reports.view', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_reports_view">View Reports</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="permission_settings_manage" name="permissions[]" value="settings.manage"
                                                    {{ in_array('settings.manage', old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_settings_manage">Manage Settings</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Role Usage Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Role Usage Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Created</label>
                                <p>{{ $role->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated</label>
                                <p>{{ $role->updated_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Used</label>
                                <p>{{ $role->last_used_at ? $role->last_used_at->format('F d, Y \a\t h:i A') : 'Never' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Users with this Role</label>
                                <p>{{ $role->users()->count() }}</p>
                            </div>
                        </div>
                    </div>

                    @if($role->users()->count() > 0)
                    <div class="mt-3">
                        <h6 class="fw-bold">Users with this Role</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users()->limit(5)->get() as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach

                                    @if($role->users()->count() > 5)
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="{{ route('users.index', ['role_id' => $role->id]) }}">View all {{ $role->users()->count() }} users</a>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all permissions checkbox
        const selectAllCheckbox = document.createElement('div');
        selectAllCheckbox.className = 'form-check mb-3';
        selectAllCheckbox.innerHTML = `
            <input class="form-check-input" type="checkbox" id="select_all_permissions">
            <label class="form-check-label fw-bold" for="select_all_permissions">Select All Permissions</label>
        `;

        const permissionsCard = document.querySelector('.card-body .card .card-body');
        permissionsCard.insertBefore(selectAllCheckbox, permissionsCard.firstChild);

        const selectAll = document.getElementById('select_all_permissions');
        const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');

        selectAll.addEventListener('change', function() {
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });

        // Update "Select All" checkbox state based on individual checkboxes
        function updateSelectAllCheckbox() {
            const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
            const someChecked = Array.from(permissionCheckboxes).some(checkbox => checkbox.checked);

            selectAll.checked = allChecked;
            selectAll.indeterminate = someChecked && !allChecked;
        }

        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectAllCheckbox);
        });

        // Initial state
        updateSelectAllCheckbox();
    });
</script>
@endpush
