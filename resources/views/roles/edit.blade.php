@extends('layouts.app')

@section('page_heading', 'Edit Role')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-center">
        <div class="w-full max-w-4xl lg:max-w-5xl">
            <div class="bg-white shadow-lg rounded-lg mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h6 class="text-lg font-semibold text-blue-600 mb-2 sm:mb-0">Edit Role: {{ $role->name }}</h6>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $role->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="p-6">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Role Name <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror" id="description" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center">
                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
                                <label class="ml-2 text-sm font-medium text-gray-700" for="is_active">Active</label>
                            </div>
                            <div class="mt-1 text-xs text-gray-500">Inactive roles cannot be assigned to users</div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
                            <div class="bg-white border border-gray-200 rounded-lg">
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_users_view" name="permissions[]" value="users.view"
                                                    {{ in_array('users.view', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_users_view">View Users</label>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_users_create" name="permissions[]" value="users.create"
                                                    {{ in_array('users.create', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_users_create">Create Users</label>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_users_edit" name="permissions[]" value="users.edit"
                                                    {{ in_array('users.edit', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_users_edit">Edit Users</label>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_users_delete" name="permissions[]" value="users.delete"
                                                    {{ in_array('users.delete', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_users_delete">Delete Users</label>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_products_view" name="permissions[]" value="products.view"
                                                    {{ in_array('products.view', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_products_view">View Products</label>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_products_create" name="permissions[]" value="products.create"
                                                    {{ in_array('products.create', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_products_create">Create Products</label>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_products_edit" name="permissions[]" value="products.edit"
                                                    {{ in_array('products.edit', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_products_edit">Edit Products</label>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_products_delete" name="permissions[]" value="products.delete"
                                                    {{ in_array('products.delete', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_products_delete">Delete Products</label>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_categories_manage" name="permissions[]" value="categories.manage"
                                                    {{ in_array('categories.manage', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_categories_manage">Manage Categories</label>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_reviews_manage" name="permissions[]" value="reviews.manage"
                                                    {{ in_array('reviews.manage', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_reviews_manage">Manage Reviews</label>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_reports_view" name="permissions[]" value="reports.view"
                                                    {{ in_array('reports.view', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_reports_view">View Reports</label>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="permission_settings_manage" name="permissions[]" value="settings.manage"
                                                    {{ in_array('settings.manage', old('permissions', $role->getPermissions())) ? 'checked' : '' }}>
                                                <label class="ml-2 text-sm text-gray-700" for="permission_settings_manage">Manage Settings</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:justify-between gap-4">
                            <a href="{{ route('roles.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</a>
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Role Usage Information -->
            <div class="bg-white shadow-lg rounded-lg mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Role Usage Information</h6>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Created</label>
                                <p class="text-sm text-gray-600">{{ $role->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Last Updated</label>
                                <p class="text-sm text-gray-600">{{ $role->updated_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Last Used</label>
                                <p class="text-sm text-gray-600">{{ $role->last_used_at ? $role->last_used_at->format('F d, Y \a\t h:i A') : 'Never' }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Users with this Role</label>
                                <p class="text-sm text-gray-600">{{ $role->users()->count() }}</p>
                            </div>
                        </div>
                    </div>

                    @if($role->users()->count() > 0)
                    <div class="mt-6">
                        <h6 class="text-base font-semibold text-gray-900 mb-3">Users with this Role</h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($role->users()->limit(5)->get() as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $user->email }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach

                                    @if($role->users()->count() > 5)
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-center">
                                            <a href="{{ route('users.index', ['role_id' => $role->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all {{ $role->users()->count() }} users</a>
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
        selectAllCheckbox.className = 'flex items-center mb-4 pb-4 border-b border-gray-200';
        selectAllCheckbox.innerHTML = `
            <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" type="checkbox" id="select_all_permissions">
            <label class="ml-2 text-sm font-semibold text-gray-700" for="select_all_permissions">Select All Permissions</label>
        `;

        const permissionsCard = document.querySelector('.p-6 .grid');
        permissionsCard.parentNode.insertBefore(selectAllCheckbox, permissionsCard);

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
