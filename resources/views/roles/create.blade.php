@extends('layouts.app')

@section('page_heading', 'Create New Role')

@section('content')
<div class="container mx-auto px-2 sm:px-4 lg:px-8">
    <div class="w-full max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:py-4 border-b border-gray-200">
                <h6 class="text-base sm:text-lg font-semibold text-blue-600 m-0">Role Information</h6>
            </div>
            <div class="p-4 sm:p-6">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-4 sm:mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Role Name <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full text-sm sm:text-base rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-3 py-2 sm:px-4 sm:py-2 @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs sm:text-sm mt-1">Enter a unique name for this role (e.g., Administrator, Editor, Viewer)</p>
                    </div>

                    <div class="mb-4 sm:mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea class="w-full text-sm sm:text-base rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-3 py-2 sm:px-4 sm:py-2 @error('description') border-red-500 @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs sm:text-sm mt-1">Provide a brief description of this role's responsibilities and access levels</p>
                    </div>

                    <div class="mb-4 sm:mb-6">
                        <div class="flex items-center">
                            <input class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                            <label class="ml-2 text-sm font-medium text-gray-700" for="is_active">Active</label>
                        </div>
                        <p class="text-gray-500 text-xs sm:text-sm mt-1 ml-7">Inactive roles cannot be assigned to users</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="p-4 sm:p-6">
                                <!-- Select All Permissions will be inserted here by JavaScript -->
                                <div id="select-all-container" class="mb-4 pb-3 border-b border-gray-200"></div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                                    <!-- User Permissions -->
                                    <div class="space-y-3">
                                        <h4 class="text-sm font-medium text-gray-800 border-b border-gray-100 pb-1">User Management</h4>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_users_view" name="permissions[]" value="users.view" {{ in_array('users.view', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_users_view">View Users</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_users_create" name="permissions[]" value="users.create" {{ in_array('users.create', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_users_create">Create Users</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_users_edit" name="permissions[]" value="users.edit" {{ in_array('users.edit', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_users_edit">Edit Users</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_users_delete" name="permissions[]" value="users.delete" {{ in_array('users.delete', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_users_delete">Delete Users</label>
                                        </div>
                                    </div>

                                    <!-- Product Permissions -->
                                    <div class="space-y-3">
                                        <h4 class="text-sm font-medium text-gray-800 border-b border-gray-100 pb-1">Product Management</h4>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_products_view" name="permissions[]" value="products.view" {{ in_array('products.view', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_products_view">View Products</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_products_create" name="permissions[]" value="products.create" {{ in_array('products.create', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_products_create">Create Products</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_products_edit" name="permissions[]" value="products.edit" {{ in_array('products.edit', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_products_edit">Edit Products</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_products_delete" name="permissions[]" value="products.delete" {{ in_array('products.delete', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_products_delete">Delete Products</label>
                                        </div>
                                    </div>

                                    <!-- Other Permissions -->
                                    <div class="space-y-3">
                                        <h4 class="text-sm font-medium text-gray-800 border-b border-gray-100 pb-1">Other Permissions</h4>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_categories_manage" name="permissions[]" value="categories.manage" {{ in_array('categories.manage', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_categories_manage">Manage Categories</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_reviews_manage" name="permissions[]" value="reviews.manage" {{ in_array('reviews.manage', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_reviews_manage">Manage Reviews</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_reports_view" name="permissions[]" value="reports.view" {{ in_array('reports.view', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_reports_view">View Reports</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="permission_settings_manage" name="permissions[]" value="settings.manage" {{ in_array('settings.manage', old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="permission_settings_manage">Manage Settings</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('roles.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-center text-sm sm:text-base rounded-md transition duration-150 ease-in-out">Cancel</a>
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base rounded-md transition duration-150 ease-in-out">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all permissions checkbox
        const selectAllContainer = document.getElementById('select-all-container');
        selectAllContainer.innerHTML = `
            <div class="flex items-center">
                <input class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" id="select_all_permissions">
                <label class="ml-2 text-sm font-semibold text-gray-800" for="select_all_permissions">Select All Permissions</label>
            </div>
        `;

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
