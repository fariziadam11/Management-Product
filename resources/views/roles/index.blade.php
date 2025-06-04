@extends('layouts.app')

@section('page_heading', 'Role Management')

@section('page_actions')
<a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
    <i class="bi bi-plus-circle mr-2"></i> Add New Role
</a>
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="bi bi-shield-lock mr-2 text-blue-600"></i>
                <span>Roles</span>
            </h3>
            <div class="flex items-center space-x-2">
                <a href="{{ route('export.form', ['type' => 'roles']) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-download mr-1.5"></i> Export
                </a>
                <a href="{{ route('import.form', ['type' => 'roles']) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-file-earmark-excel text-green-600 mr-2"></i> Import Roles
                </a>

                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('roles.create') }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="bi bi-plus-circle mr-1.5"></i> Create
                    </a>
                @endif
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <!-- Filters -->
            <form action="{{ route('roles.index') }}" method="GET" class="mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div class="col-span-1 sm:col-span-2">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                id="search" name="search" placeholder="Search roles..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div>
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="is_active">
                            <option value="">All Status</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="sort_by">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Last Updated</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="bi bi-funnel-fill mr-2"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Roles Table -->
            <div class="-mx-4 sm:mx-0 overflow-x-auto shadow-sm ring-1 ring-black ring-opacity-5">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-full sm:w-auto">Name</th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Created</th>
                            <th scope="col" class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($roles as $role)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-3 sm:px-6 py-4 whitespace-normal sm:whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                                <div class="text-sm text-gray-500 md:hidden">{{ Str::limit($role->description, 30) }}</div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-500">{{ Str::limit($role->description, 50) }}</div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $role->users_count ?? $role->users()->count() }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-normal sm:whitespace-nowrap">
                                @if($role->is_active)
                                    <x-tailwind.badge variant="success" size="sm">
                                        Active
                                    </x-tailwind.badge>
                                @else
                                    <x-tailwind.badge variant="danger" size="sm">
                                        Inactive
                                    </x-tailwind.badge>
                                @endif
                            </td>
                            <td class="hidden md:table-cell px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $role->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-1 sm:space-x-2">
                                    <a href="{{ route('roles.show', $role) }}" class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-1.5 rounded-md transition-colors duration-150">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('roles.edit', $role) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 p-1.5 rounded-md transition-colors duration-150">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-1.5 rounded-md transition-colors duration-150"
                                            onclick="document.getElementById('modal-{{ $role->id }}').classList.remove('hidden')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div id="modal-{{ $role->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title-{{ $role->id }}" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                        <!-- Backdrop -->
                                        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                        <!-- Spacer for centering -->
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <!-- Modal Dialog -->
                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <!-- Warning Icon -->
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"></path>
                                                        </svg>
                                                    </div>
                                                    <!-- Modal Content -->
                                                    <div class="mt-4 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                        <h3 class="text-lg font-semibold text-gray-900" id="modal-title-{{ $role->id }}">Confirm Delete</h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-600">
                                                                Are you sure you want to delete the role <span class="font-semibold">{{ $role->name }}</span>?
                                                                @if($role->users()->count() > 0)
                                                                <div class="mt-3 p-4 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">
                                                                    <div class="flex items-center">
                                                                        <svg class="w-5 h-5 flex-shrink-0 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"></path>
                                                                        </svg>
                                                                        <span>This role has {{ $role->users()->count() }} users assigned to it. You cannot delete a role with associated users.</span>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                @if($role->users()->count() == 0)
                                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex justify-center w-full sm:w-auto px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                                @endif
                                                <button type="button" class="inline-flex justify-center w-full sm:w-auto px-4 py-2 mt-3 sm:mt-0 bg-white text-gray-700 font-medium rounded-md border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm" onclick="document.getElementById('modal-{{ $role->id }}').classList.add('hidden')">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-shield-lock text-4xl mb-3 text-gray-400"></i>
                                    <p class="text-lg">No roles found</p>
                                    <p class="text-sm mt-1">Try adjusting your search or create a new role.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-5">
                {{ $roles->withQueryString()->links('components.tailwind.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection
