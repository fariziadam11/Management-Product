@extends('layouts.app')

@section('page_heading', 'Role Details')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-center">
        <div class="w-full max-w-4xl lg:max-w-5xl">
            <div class="bg-white shadow-lg rounded-lg mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h6 class="text-lg font-semibold text-blue-600 mb-2 sm:mb-0">{{ $role->name }}</h6>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $role->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('roles.edit', $role) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <h6 class="text-base font-semibold text-gray-900 mb-2">Description</h6>
                        <p class="text-gray-600">{{ $role->description ?: 'No description provided.' }}</p>
                    </div>

                    <div class="mb-6">
                        <h6 class="text-base font-semibold text-gray-900 mb-3">Permissions</h6>
                        @if($role->permissions && is_array($role->permissions) && count($role->permissions) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($role->permissions as $permission)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ ucwords(str_replace('.', ' ', $permission)) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No permissions assigned.</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <h6 class="text-sm font-semibold text-gray-900 mb-1">Created</h6>
                                <p class="text-sm text-gray-600">{{ $role->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <h6 class="text-sm font-semibold text-gray-900 mb-1">Last Updated</h6>
                                <p class="text-sm text-gray-600">{{ $role->updated_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <h6 class="text-sm font-semibold text-gray-900 mb-1">Last Used</h6>
                                <p class="text-sm text-gray-600">{{ $role->last_used_at ? $role->last_used_at->format('F d, Y \a\t h:i A') : 'Never' }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <h6 class="text-sm font-semibold text-gray-900 mb-1">Users with this Role</h6>
                                <p class="text-sm text-gray-600">{{ $role->users()->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users with this Role -->
            <div class="bg-white shadow-lg rounded-lg mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Users with this Role</h6>
                </div>
                <div class="p-6">
                    @if($role->users()->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($role->users()->paginate(10) as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <img class="w-6 h-6 rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $user->name }}">
                                                <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $user->email }}</td>
                                        <td class="px-4 py-3">
                                            @if($user->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-3">
                                            @if(auth()->user()->hasAnyRole('admin', 'manager', 'editor'))
                                                <a href="{{ route('users.show', $user) }}" class="inline-flex items-center p-1.5 border border-transparent rounded-md text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" title="View User">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            @else
                                                <button class="inline-flex items-center p-1.5 border border-gray-300 rounded-md text-gray-400 cursor-not-allowed" disabled title="Access restricted to Admin, Manager, or Editor">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-4">
                            {{ $role->users()->paginate(10)->links() }}
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-blue-700">No users are currently assigned to this role.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Role Audit History -->
            <div class="bg-white shadow-lg rounded-lg mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Audit History</h6>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changes</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($role->audits()->with('user')->latest()->take(10)->get() as $audit)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        @if($audit->user)
                                            <div class="flex items-center">
                                                <img class="w-6 h-6 rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($audit->user->name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $audit->user->name }}">
                                                <span class="text-sm font-medium text-gray-900">{{ $audit->user->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">System</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($audit->event == 'created')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Created</span>
                                        @elseif($audit->event == 'updated')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Updated</span>
                                        @elseif($audit->event == 'deleted')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Deleted</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $audit->event }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if(!empty($audit->new_values))
                                            <button class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                    type="button"
                                                    onclick="toggleCollapse('auditDetails{{ $audit->id }}')"
                                                    aria-expanded="false">
                                                View Changes
                                            </button>
                                            <div class="hidden mt-2" id="auditDetails{{ $audit->id }}">
                                                <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                                                    <dl class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                                                        @foreach($audit->new_values as $key => $value)
                                                            <div>
                                                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                                                <dd class="text-sm text-gray-900">
                                                                    @if(is_array($value))
                                                                        {{ json_encode($value) }}
                                                                    @elseif(is_bool($value))
                                                                        {{ $value ? 'Yes' : 'No' }}
                                                                    @else
                                                                        {{ $value }}
                                                                    @endif
                                                                </dd>
                                                            </div>
                                                        @endforeach
                                                    </dl>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">No changes recorded</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $audit->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No audit records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($role->audits()->count() > 10)
                        <div class="text-center mt-4">
                            <a href="{{ route('audits.model', ['type' => 'role', 'id' => $role->id]) }}" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View All Audit History
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCollapse(elementId) {
    const element = document.getElementById(elementId);
    const button = document.querySelector(`[onclick="toggleCollapse('${elementId}')"]`);

    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
        button.setAttribute('aria-expanded', 'true');
    } else {
        element.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
    }
}
</script>
@endsection
