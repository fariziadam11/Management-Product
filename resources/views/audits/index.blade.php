@extends('layouts.app')

@section('page_heading', 'Audit Log')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <h3 class="text-lg font-semibold text-blue-600">Filter Audit Logs</h3>
            <div class="flex items-center space-x-2">
                <a href="{{ route('audits.export') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-download mr-1.5"></i> Export
                </a>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <form action="{{ route('audits.index') }}" method="GET" class="mb-0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                        <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 select2" id="user_id" name="user_id">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="auditable_type" class="block text-sm font-medium text-gray-700 mb-1">Model Type</label>
                        <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="auditable_type" name="auditable_type">
                            <option value="">All Types</option>
                            <option value="user" {{ request('auditable_type') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="role" {{ request('auditable_type') == 'role' ? 'selected' : '' }}>Role</option>
                            <option value="category" {{ request('auditable_type') == 'category' ? 'selected' : '' }}>Category</option>
                            <option value="product" {{ request('auditable_type') == 'product' ? 'selected' : '' }}>Product</option>
                            <option value="product_review" {{ request('auditable_type') == 'product_review' ? 'selected' : '' }}>Product Review</option>
                        </select>
                    </div>
                    <div>
                        <label for="event" class="block text-sm font-medium text-gray-700 mb-1">Event</label>
                        <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="event" name="event">
                            <option value="">All Events</option>
                            <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                            <option value="restored" {{ request('event') == 'restored' ? 'selected' : '' }}>Restored</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                            <input type="date" class="w-full sm:flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 text-sm" id="from_date" name="from_date" value="{{ request('from_date') }}">
                            <span class="text-gray-500 hidden sm:inline">to</span>
                            <input type="date" class="w-full sm:flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 text-sm" id="to_date" name="to_date" value="{{ request('to_date') }}">
                        </div>
                    </div>
                    <div class="md:col-span-2 lg:col-span-4">
                        <div class="flex justify-end space-x-3 mt-4">
                            <a href="{{ route('audits.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md transition-colors duration-150 ease-in-out">Reset</a>
                            <button type="submit" class="w-full sm:w-auto mt-2 sm:mt-0 px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md transition-colors duration-150 ease-in-out">Apply Filters</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <x-tailwind.card>
        <div class="overflow-x-auto -mx-4 sm:-mx-0">
            <x-tailwind.table :headers="$headers = ['Event', 'Model', 'User', 'Date', 'Actions']">
            @forelse($audits as $audit)
                <tr>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium">
                        @if($audit->event == 'created')
                            <x-tailwind.badge variant="success" icon="plus-circle" size="xs" class="sm:hidden">
                                Created
                            </x-tailwind.badge>
                            <x-tailwind.badge variant="success" icon="plus-circle" size="sm" class="hidden sm:inline-flex">
                                Created
                            </x-tailwind.badge>
                        @elseif($audit->event == 'updated')
                            <x-tailwind.badge variant="info" icon="pencil" size="xs" class="sm:hidden">
                                Updated
                            </x-tailwind.badge>
                            <x-tailwind.badge variant="info" icon="pencil" size="sm" class="hidden sm:inline-flex">
                                Updated
                            </x-tailwind.badge>
                        @elseif($audit->event == 'deleted')
                            <x-tailwind.badge variant="danger" icon="trash" size="xs" class="sm:hidden">
                                Deleted
                            </x-tailwind.badge>
                            <x-tailwind.badge variant="danger" icon="trash" size="sm" class="hidden sm:inline-flex">
                                Deleted
                            </x-tailwind.badge>
                        @else
                            <x-tailwind.badge variant="secondary" size="xs" class="sm:hidden">
                                {{ ucfirst($audit->event) }}
                            </x-tailwind.badge>
                            <x-tailwind.badge variant="secondary" size="sm" class="hidden sm:inline-flex">
                                {{ ucfirst($audit->event) }}
                            </x-tailwind.badge>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ class_basename($audit->auditable_type) }} #{{ $audit->auditable_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ optional($audit->user)->name ?? 'System' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $audit->created_at->format('M d, Y H:i:s') }}
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                        <x-tailwind.button
                            href="{{ route('audits.show', $audit) }}"
                            variant="outline-primary"
                            size="xs"
                            icon="eye"
                            class="sm:hidden"
                        >
                            View
                        </x-tailwind.button>
                        <x-tailwind.button
                            href="{{ route('audits.show', $audit) }}"
                            variant="outline-primary"
                            size="sm"
                            icon="eye"
                            class="hidden sm:inline-flex"
                        >
                            View Details
                        </x-tailwind.button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs sm:text-sm text-gray-500">
                        No audit logs found.
                    </td>
                </tr>
            @endforelse
            </x-tailwind.table>
        </div>

        @if($audits->hasPages())
            <div class="mt-4 sm:mt-6 flex justify-center">
                <div class="pagination-tailwind">
                    {{ $audits->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </x-tailwind.card>
</div>
@endsection

@push('styles')
<style>
    /* Responsive table styles */
    @media (max-width: 640px) {
        .pagination-tailwind nav > div > span,
        .pagination-tailwind nav > div > button {
            @apply px-2 py-1 text-xs;
        }
    }
    /* Custom styles for pre elements */
    pre {
        margin: 0;
        white-space: pre-wrap;
    }

    /* Custom styles for Laravel pagination with Tailwind */
    .pagination-tailwind nav > div {
        @apply flex justify-between items-center;
    }

    .pagination-tailwind nav > div > div:first-child {
        @apply hidden sm:flex sm:flex-1 sm:items-center sm:justify-between;
    }

    .pagination-tailwind nav > div > div:first-child > div:first-child {
        @apply text-sm text-gray-700;
    }

    .pagination-tailwind nav > div > div:first-child > div:last-child {
        @apply flex;
    }

    .pagination-tailwind nav span.relative,
    .pagination-tailwind nav button.relative {
        @apply relative inline-flex items-center px-4 py-2 text-sm font-medium;
    }

    .pagination-tailwind nav span.relative.text-gray-700 {
        @apply text-gray-500 bg-white border border-gray-300;
    }

    .pagination-tailwind nav button.relative.text-gray-500 {
        @apply text-gray-500 bg-white border border-gray-300 hover:bg-gray-50;
    }
</style>
@endpush
