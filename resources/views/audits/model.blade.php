@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="text-base sm:text-lg md:text-xl font-semibold text-gray-800">Audit History for {{ $modelName }}</h2>
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-2.5 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md transition-colors duration-150 ease-in-out text-xs sm:text-sm">
                    <i class="bi bi-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="p-3 sm:p-4 md:p-6">
            @if($audits->count() > 0)
                <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th scope="col" class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changes</th>
                                <th scope="col" class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($audits as $audit)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap">
                                        @if(isset($audit->event))
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $audit->event === 'created' ? 'bg-green-100 text-green-800' : 
                                              ($audit->event === 'updated' ? 'bg-blue-100 text-blue-800' : 
                                              ($audit->event === 'deleted' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($audit->event) }}
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                        {{ optional($audit->user)->name ?? 'System' }}
                                    </td>
                                    <td class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 md:py-4 text-xs sm:text-sm text-gray-500">
                                        @if(isset($audit->event) && $audit->event === 'updated' && !empty($audit->old_values) && !empty($audit->new_values))
                                            @php
                                                $oldValues = (array) ($audit->old_values ?? []);
                                                $newValues = (array) ($audit->new_values ?? []);
                                                $changedFields = array_unique(array_merge(
                                                    array_keys($oldValues),
                                                    array_keys($newValues)
                                                ));
                                            @endphp
                                            @if(count($changedFields) > 0)
                                                <div class="space-y-2">
                                                    @foreach($changedFields as $field)
                                                        @if(isset($oldValues[$field]) || isset($newValues[$field]))
                                                            <div>
                                                                <span class="font-medium text-gray-700 text-xs sm:text-sm">{{ $field }}:</span><br>
                                                                @if(isset($oldValues[$field]) && (!isset($newValues[$field]) || $oldValues[$field] != $newValues[$field]))
                                                                    <span class="text-red-600">
                                                                        @if(is_array($oldValues[$field]) || is_object($oldValues[$field]))
                                                                            {{ json_encode($oldValues[$field]) }}
                                                                        @else
                                                                            {{ $oldValues[$field] ?? 'null' }}
                                                                        @endif
                                                                    </span>
                                                                    @if(isset($newValues[$field]) && $oldValues[$field] != $newValues[$field])
                                                                        <i class="bi bi-arrow-right mx-2 text-gray-500"></i>
                                                                        <span class="text-green-600">
                                                                            @if(is_array($newValues[$field]) || is_object($newValues[$field]))
                                                                                {{ json_encode($newValues[$field]) }}
                                                                            @else
                                                                                {{ $newValues[$field] ?? 'null' }}
                                                                            @endif
                                                                        </span>
                                                                    @elseif(isset($newValues[$field]))
                                                                        <span class="text-green-600 ml-2">(No change)</span>
                                                                    @endif
                                                                @elseif(isset($newValues[$field]))
                                                                    <span class="text-green-600">
                                                                        @if(is_array($newValues[$field]) || is_object($newValues[$field]))
                                                                            {{ json_encode($newValues[$field]) }}
                                                                        @else
                                                                            {{ $newValues[$field] ?? 'null' }}
                                                                        @endif
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs sm:text-sm">No changes detected</span>
                                            @endif
                                        @elseif(isset($audit->event) && $audit->event === 'created' && !empty($audit->new_values))
                                            <div class="space-y-2">
                                                @foreach((array) $audit->new_values as $field => $value)
                                                    <div>
                                                        <span class="font-medium text-gray-700 text-xs sm:text-sm">{{ $field }}:</span>
                                                        <span class="text-green-600">
                                                            @if(is_array($value) || is_object($value))
                                                                {{ json_encode($value) }}
                                                            @else
                                                                {{ $value ?? 'null' }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif(isset($audit->event) && $audit->event === 'deleted' && !empty($audit->old_values))
                                            <div class="space-y-2">
                                                @foreach((array) $audit->old_values as $field => $value)
                                                    <div>
                                                        <span class="font-medium text-gray-700 text-xs sm:text-sm">{{ $field }}:</span>
                                                        <span class="text-red-600">
                                                            @if(is_array($value) || is_object($value))
                                                                {{ json_encode($value) }}
                                                            @else
                                                                {{ $value ?? 'null' }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs sm:text-sm">No changes recorded</span>
                                        @endif
                                    </td>
                                    <td class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                        {{ $audit->created_at ? $audit->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="px-2 sm:px-3 md:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden md:table-cell">
                                        {{ $audit->ip_address ?? 'N/A' }}
                                        @if(isset($audit->user_agent))
                                        <div class="mt-1 lg:hidden">
                                            <span class="text-xs text-gray-400">Agent: {{ Str::limit($audit->user_agent, 30) }}</span>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 sm:mt-6 flex justify-center">
                    <div class="pagination-tailwind">
                        {{ $audits->links() }}
                    </div>
                </div>
            @else
                <div class="rounded-md bg-blue-50 p-3 sm:p-4">
                    <div class="flex items-start sm:items-center">
                        <div class="flex-shrink-0 mt-0.5 sm:mt-0">
                            <i class="bi bi-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs sm:text-sm text-blue-700">No audit records found for this item.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Responsive table styles */
    @media (max-width: 640px) {
        .pagination-tailwind nav > div > span,
        .pagination-tailwind nav > div > button {
            @apply px-2 py-1 text-xs;
        }
    }
</style>
<style>
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

    .pagination-tailwind nav span.relative.bg-white {
        @apply z-10 bg-blue-50 border-blue-500 text-blue-600;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips using Tippy.js or a similar library
        // This is a placeholder for tooltip functionality
        const tooltipTriggers = document.querySelectorAll('.tooltip-trigger');
        tooltipTriggers.forEach(trigger => {
            trigger.addEventListener('mouseenter', function() {
                const title = this.getAttribute('title');
                this.setAttribute('data-original-title', title);
                this.removeAttribute('title');
            });

            trigger.addEventListener('mouseleave', function() {
                const title = this.getAttribute('data-original-title');
                this.setAttribute('title', title);
                this.removeAttribute('data-original-title');
            });
        });
    });
</script>
@endpush
@endsection
